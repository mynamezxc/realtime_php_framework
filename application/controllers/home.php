<?php
    
    class home extends ZXC_controller implements controller {

        public function __construct() {
            parent::__construct();
        }

        public function index() {
            ////////////// Controller ////////////
            $this->call->controller("controller_demo")->sayHello();
            
            // Or
            // $controller_demo = $this->call->controller("controller_demo");
            // $controller_demo->sayHello();

            ////////////// Model ///////////////
            $categories = $this->call->model("category_model")->getAll();
            $categories[0]->getProductList();
            var_dump($categories[0]->productList);
            
            // Or
            // $model_demo = $this->call->model("model_demo");
            // $demo_array = $model_demo->getAll();
            // demos is an arrays with values is object
            
            ////////////// View ///////////////
            $data = [
                'name' => 'nguyen hoang',
                'namsinh' => '1998'
            ];
            $this->call->view("realtime", $data);
            
            ///////////// Helper ///////////////
            $this->call->helper("helper_demo");
            //getShow();
        }

        public function abc() {
            echo 'a';
        }

    }