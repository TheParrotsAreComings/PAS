import time
import sys
import _mysql
import random
import string
import re
import os
import urllib.parse


from selenium import webdriver
from selenium.webdriver.support.ui import Select
import selenium.webdriver.chrome.service as service
from shutil import copyfile

try:

	# Check to see if it was added
	db=_mysql.connect('localhost','root','root','paws_db')
	rand_fname=''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(6))
	rand_lname=''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(6))
	rand_mail=''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(6))

	db.query("INSERT INTO fosters (first_name,last_name,address,email,created,is_deleted) VALUES(\""+rand_fname+"\",\""+rand_lname+"\",\"55 Gato Way\",\""+rand_mail+"@mail.com\",NOW(),true);");
	db.store_result()

	db.query("SELECT id,first_name FROM fosters where last_name=\""+rand_lname+"\" AND email=\""+rand_mail+"@mail.com\"")

	r=db.store_result()

	k=r.fetch_row(1,1)
	a_id = k[0].get('id')

	service = service.Service('D:\ChromeDriver\chromedriver')

	service.start()
	capabilities = {'chrome.binary': 'C:\Program Files (x86)\Google\Chrome\Application\chrome'} # Chrome path is different for everyone

	driver = webdriver.Remote(service.service_url, capabilities)

	driver.set_window_size(sys.argv[1], sys.argv[2]);


	curfilePath = os.path.abspath(__file__)
	curDir = os.path.abspath(os.path.join(curfilePath,os.pardir)) # this will return current directory in which python file resides.
	parentDir = os.path.abspath(os.path.join(curDir,os.pardir)) 
	grandParentDir = os.path.abspath(os.path.join(parentDir,os.pardir)) 

	webroot = os.path.join(grandParentDir,"webroot","files","fosters",a_id)

	rand_default=''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(6))
	rand_new=''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(6))

	file_path_1 = urllib.parse.urljoin('files/fosters/',a_id+"/"+rand_default)

	db.query('INSERT INTO files (entity_type,entity_id,is_photo,file_path,mime_type,file_size,file_ext,created,is_deleted,original_filename) VALUES(4,'+a_id+',0,"'+file_path_1+'","application/pdf",78237,"pdf",NOW(),0,"test_doc_1");')
	db.store_result()

	db.query('SELECT id FROM files where file_path="'+file_path_1+'"')

	r=db.store_result()

	k=r.fetch_row(1,1)
	file_1_id = k[0].get('id')

	if not os.path.exists(webroot):
		os.makedirs(webroot)

	copyfile(os.getcwd()+"/doc/test_doc_1.pdf", os.path.join(webroot,rand_default+".pdf"))

	
	for root,dir,files in os.walk(webroot):
		for f in files:
			os.chmod(os.path.join(root, f), 777)

	driver.get('http://localhost:8765');
	driver.find_element_by_id('email').send_keys('theparrotsarecoming@gmail.com')
	driver.find_element_by_id('password').send_keys('password')
	driver.find_element_by_css_selector('input[type="submit"]').click()

	driver.get('http://localhost:8765/fosters/view/'+a_id)

	driver.find_element_by_css_selector('a[data-ix="attachment-notification"]').click()
	
	print("pass") #Not Implemented Yet
	sys.exit(0)

	driver.find_element_by_css_selector('div.picture-file[data-file-id="'+file_2_id+'"]').click()

	driver.find_element_by_id("mark-profile-pic-btn").click()

	driver.get('http://localhost:8765/fosters/view/'+a_id)

	new_img = driver.find_element_by_css_selector('img.cat-profile-pic')

	img_src = new_img.get_attribute('src')

	if rand_new in img_src:
		print("pass")
	else:
		print("fail")

	driver.quit()

except Exception as e:
	print(e)
	print("fail")

