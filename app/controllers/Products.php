<?php

class Products extends Controller {

    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        //new model instance
        $this->productModel = $this->model('Product');
    }

    public function index() {

        $products = $this->productModel->getProduct();
        $data = [
            'products' => $products
        ];

        $this->view('product/index', $data);
    }

    public function list() {

        $routers = $this->routeModel->getRouter();
        $data = [
            'routers' => $routers
        ];
        $dataset = array(
            "echo" => 1,
            "totalrecords" => count($routers),
            "totaldisplayrecords" => count($routers),
            "data" => $routers
        );


        echo json_encode($dataset);
//print_R(json_encode($dataset)); //die();
        //$this->view('router/index', $data);
    }

    //add new post
    public function add() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'price' => trim($_POST['price']),
                 'status' => trim($_POST['status']),
            ];
//            echo "<pre>";
//            print_r($data); die();

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }
            if (empty($data['price'])) {
                $data['price_err'] = 'Please enter the price';
            }
          
            //validate error free
            if (empty($data['name_err']) && empty($data['price_err'])) {
                if ($this->productModel->addProduct($data)) {
                    flash('Product_message', 'Your Product have been added');
                    redirect('products');
                } else {
                    die('something went wrong');
                }

                //laod view with error
            } else {
                $this->view('products/add', $data);
            }
        } else {
            $data = [
                'name' => (isset($_POST['name']) ? trim($_POST['name']) : ''),
                'price' => (isset($_POST['price']) ? trim($_POST['price']) : ''),
                 'status' => (isset($_POST['price']) ? trim($_POST['status']) : '')
            ];

            $this->view('products/add', $data);
        }
    }

    //show single post 
    public function show($id) {
        $products = $this->productModel->getProductById($id);

        $data = [
            'products' => $products
        ];
        echo json_encode($data);
        //$this->view('products/show', $data);
    }

    //edit post
    public function edit($id='') {
     
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
            ];
            //validate the title
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter post title';
            }
            //validate the body
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter the post content';
            }

            //validate error free
            if (empty($data['title_err']) && empty($data['body_err'])) {
                if ($this->productModel->updateProduct($data)) {
                    flash('products_message', 'Your products have been updated');
                    redirect('products');
                } else {
                    die('something went wrong');
                }

                //laod view with error
            } else {
                $this->view('products/edit', $data);
            }
        } else {
            //check for the owner and call method from post model
            $post = $this->productModel->getProductById($id);
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('product');
            }
            $data = [
                'id' => $id,
                'name' => $post->name,
                'price' => $post->price
            ];

            $this->view('products/edit', $data);
        }
    }

    //delete post
    public function delete($id='') {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            //check for owner
            $post = $this->productModel->getProductById($id);
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('products');
            }

            //call delete method from post model
            if ($this->productModel->deleteProduct($id)) {
                flash('product_message', 'Product Removed');
                redirect('products');
            } else {
                die('something went wrong');
            }
        } else {
            redirect('products');
        }
    }

}
