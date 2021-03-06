<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Litters Controller
 *
 * @property \App\Model\Table\LittersTable $Litters
 */
class LittersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $session_user = $this->request->session()->read('Auth.User');
        $user_model = TableRegistry::get('Users');
        if ($user_model->isFoster($session_user)) {
            $this->Flash->error("You aren't allowed to do that.");
            return $this->redirect(['controller'=>'cats','action'=>'index']);
        }
        $can_add = ($user_model->isAdmin($session_user) || $user_model->isCore($session_user));

        $this->paginate = [
            'contain' => ['Cats', 'Cats.Breeds'],
            'conditions' => ['Litters.is_deleted' => 0]
        ];

        $filesDB = TableRegistry::get('Files');

        if(!empty($this->request->query['mobile-search'])){
            $this->paginate['conditions']['litter_name LIKE'] = '%'.$this->request->query['mobile-search'].'%';
        }else if(!empty($this->request->query)){
            foreach($this->request->query as $field => $query){
				if(is_array($query) || $field == 'page'){
					continue;
				}
                if($field == 'dob'){
                    if(!empty($query)){
                        $this->paginate['conditions'][$field] = date('Y-m-d',strtotime($query));
                    }
                }else if(!empty($query)){
                    if(preg_match('/count/',$field)){
                        $this->paginate['conditions'][$field] = $query;
                    }else{
                        $this->paginate['conditions'][$field.' LIKE'] = '%'.$query.'%';
                    }
                }
            }
            $this->request->data = $this->request->query;
        }


        $litters = $this->paginate($this->Litters);

        foreach($litters as $litter) {
            if(!empty($litter->cats)) {
                foreach($litter->cats as $cat) {
                    if($cat->profile_pic_file_id > 0) {
                        $cat->profile_pic = $filesDB->get($cat->profile_pic_file_id);
                    } else {
                        $cat->profile_pic = null;
                    }
                }
            }
        }

        $count = [0,1,2,3,4,5,6,7,8,10,11,12,13,14,15];
        $this->set(compact('litters','count','can_add'));
        $this->set('_serialize', ['litters']);

    }

    /**
     * View method
     *
     * @param string|null $id Litter id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $session_user = $this->request->session()->read('Auth.User');
        $user_model = TableRegistry::get('Users');
        if ($user_model->isFoster($session_user)) {
            $this->Flash->error("You aren't allowed to do that.");
            return $this->redirect(['controller'=>'cats','action'=>'index']);
        }
        $can_delete = ($user_model->isAdmin($session_user));
        $can_edit = ($can_delete || $user_model->isCore($session_user));

        $filesDB = TableRegistry::get('Files');

        $litter = $this->Litters->get($id, [
            'contain' => ['Cats','Cats.Breeds']
        ]);

        $breeds = TableRegistry::get('Breeds')->find('list', ['keyField' => 'id', 'valueField' => 'breed']);

        if(!empty($litter->cats)) {
            foreach($litter->cats as $cat) {
                if($cat->profile_pic_file_id > 0) {
                    $cat->profile_pic = $filesDB->get($cat->profile_pic_file_id);
                } else {
                    $cat->profile_pic = null;
                }
            }
        }

        $this->set(compact('litter', 'can_delete', 'can_edit', 'breeds'));
        $this->set('_serialize', ['litter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $session_user = $this->request->session()->read('Auth.User');
        $users_model = TableRegistry::get('Users');
        if ($users_model->isFoster($session_user) || $users_model->isVolunteer($session_user)) {
            $this->Flash->error("You aren't allowed to do that.");
            return $this->redirect(['controller'=>'cats','action'=>'index']);
        }

        $litter = $this->Litters->newEntity();
        if ($this->request->is('post')) {
            
            // extract and put together birthdate into proper format
            $year =  $this->request->data['dob']['year'];
            $month = $this->request->data['dob']['month'];
            $day = $this->request->data['dob']['day'];
            $dob = $year.'-'.$month.'-'.$day;
            $this->request->data['dob'] = $dob;

            // initial creation, not deleted
            $this->request->data['is_deleted'] = 0;
            $this->request->data['the_cat_count'] = 0;
            $this->request->data['kitten_count'] = 0;

            $litter = $this->Litters->patchEntity($litter, $this->request->data);
            
            if ($this->Litters->save($litter)) {
                $this->Flash->success(__('The litter has been saved.'));

				$this->request->session()->write('Litter_DOB',$dob);
                return $this->redirect(['controller' => 'cats', 'action' => 'add', $litter->id]);
            }
            $this->Flash->error(__('The litter could not be saved. Please, try again.'));
        }
        $this->set(compact('litter'));
        $this->set('_serialize', ['litter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Litter id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session_user = $this->request->session()->read('Auth.User');
        $users_model = TableRegistry::get('Users');
        if ($users_model->isFoster($session_user) || $users_model->isVolunteer($session_user)) {
            $this->Flash->error("You aren't allowed to do that.");
            return $this->redirect(['controller'=>'cats','action'=>'index']);
        }

        $litter = $this->Litters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $litter = $this->Litters->patchEntity($litter, $this->request->data);
            if ($this->Litters->save($litter)) {
                $this->Flash->success(__('The litter has been saved.'));

                return $this->redirect(['action' => 'view', $litter->id]);
            }
            $this->Flash->error(__('The litter could not be saved. Please, try again.'));
        }
        $this->set(compact('litter'));
        $this->set('_serialize', ['litter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Litter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $session_user = $this->request->session()->read('Auth.User');
        if (!TableRegistry::get('Users')->isAdmin($session_user)) {
            $this->Flash->error("You aren't allowed to do that.");
            return $this->redirect(['controller'=>'cats','action'=>'index']);
        }

        $litter = $this->Litters->get($id);
        $this->request->data['is_deleted'] = 1;
        $litter = $this->Litters->patchEntity($litter, $this->request->data);
        if ($this->Litters->save($litter)) {
            $this->Flash->success(__('The litter has been deleted'));
            return $this->redirect(['controller' => 'litters', 'action' => 'index']);
        } else {
            $this->Flash->error(__('The litter could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'litters', 'action' => 'index']);
    }

    public function addExistingCatToLitter($litter_id){
		$litter = $this->Litters->get($litter_id);
		$this->set(compact('litter','litter_id'));
    }

    public function addSuccess($litter_id){
		$this->Flash->success(__('The cat has been added!'));
		return $this->redirect(['action'=>'view',$litter_id]);
	}

	public function ajaxFindCat($name){
		$this->autoRender = false;
		$cats = TableRegistry::get('Cats');
		$results = $cats->find('all')->where(['litter_id IS NULL','cat_name LIKE' => '%'.$name.'%'])->contain(['Breeds']);
		ob_clean();
		echo json_encode($results);
		exit(0);
	}

	public function ajaxAssignCat($cat_id,$litter_id){
		$this->autoRender = false;
		$cats = TableRegistry::get('Cats');

		$cat = $cats->get($cat_id);
		$cat->litter_id = $litter_id;

        $litter = $this->Litters->get($litter_id);
        if ($cat->is_kitten) {
            $litter->kitten_count = $litter->kitten_count + 1;
        } else {
            $litter->the_cat_count = $litter->the_cat_count + 1;
        }
        $this->Litters->save($litter);

		$results = array('error'=>empty($cats->save($cat)));

		ob_clean();
		echo json_encode($results);
		exit(0);
	}
}
