<?php
namespace App\Controller;

use App\Controller\AppController;
Use Cake\ORM\TableRegistry;
/**
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PhoneNumbers'],
            'conditions' => ['Contacts.is_deleted' => 0]
        ];

        $phones = TableRegistry::get('PhoneNumbers')->find('all')->where(['entity_type' => 2]);

        if(!empty($this->request->query['mobile-search'])){
            $this->paginate['conditions']['first_name LIKE'] = '%'.$this->request->query['mobile-search'].'%';
        } else if(!empty($this->request->query)){

            if(!empty($this->request->query['phone'])){
                $search_phones = $this->Contacts->filterPhones($this->request->query['phone']);
                unset($this->request->query['phone']);
            }

            foreach($this->request->query as $field => $query){
                if ($field == 'page'){
                    continue;
                }
                if(($field == 'is_deleted') && $query != ''){
                    $this->paginate['conditions']['Contacts.'.$field] = (int)$query;
                }else if ($field == 'rating' && !empty($query)){
                    if(preg_match('/rating/',$field)){
                        $this->paginate['conditions'][$field] = $query;
                    }
                }else if (!empty($query)) {
                    $this->paginate['conditions'][$field.' LIKE'] = '%'.$query.'%';
                }
            }

            if(!empty($search_phones)){
                $this->paginate['conditions']['contacts.id IN'] = $search_phones;
            }

            $this->request->data = $this->request->query;
        }

        $contacts = $this->paginate($this->Contacts);

        $this->set(compact('contacts', 'entity_type','phones'));
        $this->set('_serialize', ['contacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => []
        ]);

        $this->set('contact', $contact);
        $this->set('_serialize', ['contact']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $phoneTable = TableRegistry::get('PhoneNumbers');

        $contact = $this->Contacts->newEntity();

        if ($this->request->is('post')) {
            //debug($this->request->data); die;
            $phones= $this->request->data['phones'];
            unset($this->request->data['phones']);
            
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            $contact['is_deleted'] = 0;
            if ($this->Contacts->save($contact)) {
                $id = $contact->id;
                if(!($phones['phone_num'] === '')){
                    for($i = 0; $i < count($phones['phone_type']); $i++) {
                        $new_phone = $phoneTable->newEntity();
                        $new_phone->entity_id = $id;
                        $new_phone->entity_type = 2;
                        $new_phone->phone_type = $phones['phone_type'][$i];
                        $new_phone->phone_num = $phones['phone_num'][$i];
                        if(!($new_phone['phone_num'] === '')){
                            $phoneTable->save($new_phone);
                        }
                    }
                }
                $this->Flash->success(__('The contact has been saved.'));
                
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact could not be saved. Please, try again.'));
        }
        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => ['PhoneNumbers']
        ]);
        $phoneTable = TableRegistry::get('PhoneNumbers');
        $phone = TableRegistry::get('PhoneNumbers')->find()->where(['entity_id' => $id])->where(['entity_type' => 2]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!empty($this->request->data['phones'])){
                $phones = $this->request->data['phones'];
            }

            if(!empty($phones)){
                unset($this->request->data['phones']);
            }
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {

                if(!empty($phones)){
                    for($i = 0; $i < count($phones['phone_type']); $i++) {
                        $new_phone = $phoneTable->newEntity();
                        $new_phone->entity_id = $id;
                        $new_phone->entity_type = 2;
                        $new_phone->phone_type = $phones['phone_type'][$i];
                        $new_phone->phone_num = $phones['phone_num'][$i];
                        if(!($new_phone['phone_num'] === '')){
                            $phoneTable->save($new_phone);
                        }
                    }
                }
                $this->Flash->success(__('The contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact could not be saved. Please, try again.'));
        }

        $this->set(compact('contact', 'phone'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $contact = $this->Contacts->get($id);
        $this->request->data['is_deleted'] = 1;
        $contact = $this->Contacts->patchEntity($contact, $this->request->data);
        if ($this->Contacts->save($contact)) {
            $this->Flash->success(__('The contact has been deleted.'));
        } else {
            $this->Flash->error(__('The contact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
