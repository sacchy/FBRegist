<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');
App::uses('DBCenter','Vendor');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class RegistersController extends AppController {

    /**
     * This controller does not use a model
     *
     * @var array
     */
	public $uses = array();

    /**
     * Displays a view
     */
    public function display() 
    {
        if($this->request->is('post'))
        {
            $this->redirect(array('action'=>'regist'));
        }
    }

    /*
     * @brief Register Data on DB
     */
    public function regist()
    {
        // Try Facebook Connect
        $this->connectFb();
        $fb = $this->facebook->getUser();
         
        try 
        {
            $this->DBCenter = new DBCenter();
            $this->DBCenter->initDB();
            $res = $this->DBCenter->getUserID(0);

            mt_srand();
            $data = array();
            for ($i = 0; $i < count($res);$i++)
            {
                $temp = array();

                $user = $this->facebook->api("{$res[$i]["user_id"]}/");
                $temp["id"] = $res[$i]["id"];
                array_key_exists("id",$user) ? $temp["fb_id"] = $res[$i]["user_id"] : $temp["fb_id"] = 0;
                array_key_exists("email",$user) ? $temp["email"] = $user["email"] : $temp["email"] = "none";
                array_key_exists("hometown",$user) ? $temp["hometown"] = $user["hometown"]["name"] : $temp["hometown"] = "none";
                array_key_exists("birthday",$user) ? $temp["birthday"] = $user["birthday"] : $temp["birthday"] = "none";
                array_key_exists("hobby",$user) ? $temp["hobby"] = $user["hobby"] : $temp["hobby"] = 0;
                array_key_exists("gender",$user) ? "male" === $user["gender"] ? $temp["gender"] = 0 : $temp["gender"] = 1 : $temp["gender"] = mt_rand(0,1);
                array_key_exists("age",$user) ? $temp["age"] = $user["age"] : $temp["age"] = mt_rand(18,28);
                array_key_exists("height",$user) ? $temp["height"] = $user["height"] : "male" === $user["gender"] ? $temp["height"] = mt_rand(160,185) : $temp["height"] = mt_rand(160,175);
                array_key_exists("bodytype",$user) ? $temp["bodytype"] = $user["bodytype"] : $temp["bodytype"] = mt_rand(0,2);
                array_key_exists("sports",$user) ? $temp["sports"] = $user["sports"] : $temp["sports"] = mt_rand(0,15);
                array_key_exists("marriage_history",$user) ? $temp["marriage_history"] = $user["marriage_history"] : $temp["marriage_history"] = 0;
                array_key_exists("race",$user) ? $temp["race"] = $user["race"] : $temp["race"] = 0;
                array_key_exists("education",$user) ? $temp["education"] = $user["education"] : $temp["education"] = mt_rand(0,5);
                array_key_exists("language",$user) ? $temp["language"] = $user["language"] : $temp["language"] = 0;
                array_key_exists("smoke",$user) ? $temp["smoke"] = $user["smoke"] : $temp["smoke"] = 0;
                array_key_exists("drinking",$user) ? $temp["drinking"] = $user["drinking"] : $temp["drinking"] = mt_rand(0,3);
                array_key_exists("driving",$user) ? $temp["driving"] = $user["driving"] : $temp["driving"] = 0;
                array_key_exists("exercise",$user) ? $temp["exercise"] = $user["exercise"] : $temp["exercise"] = mt_rand(0,3);
                array_key_exists("children_num",$user) ? $temp["children_num"] = $user["children_num"] : $temp["children_num"] = 0;
                array_key_exists("want_children",$user) ? $temp["want_children"] = $user["want_children"] : $temp["want_children"] = mt_rand(0,5);
                array_key_exists("job",$user) ? $temp["job"] = $user["job"] : $temp["job"] = mt_rand(0,22);
                array_key_exists("salary",$user) ? $temp["salary"] = $user["salary"] : $temp["salary"] = mt_rand(0,6);
                array_key_exists("pet",$user) ? $temp["pet"] = $user["pet"] : $temp["pet"] = mt_rand(0,2);
                array_key_exists("constellation",$user) ? $temp["constellation"] = $user["constellation"] : $temp["constellation"] = 0;
                array_push($data,$temp);
            }
            $this->DBCenter->setUserData($data);
        }
        catch (FacebookApiException $e)
        {
            error_log($e);
        }

        $this->set(compact('fb'));
    }
}
