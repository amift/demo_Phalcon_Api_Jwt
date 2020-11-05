<?php


use Firebase\JWT\JWT;

class ApiController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function getAllUsersAction()
    {
        $headRequest = $this->request->getHeaders();
        $jwt = $headRequest['Jwt'];
        if($jwt)
        {
            try {
                $key  = base64_decode('PhalconDemoApiJWT');
                $decoded = JWT::decode($jwt, $key, array('HS256'));
                $users = Users::find();
                $data = [];
                foreach ($users as $user)
                {
                    $data[] = [
                        "id" => $user->id,
                        "name" => $user->name,
                        "email" => $user->email,
                        "phone" => $user->phone,
                    ];
                }
                return json_encode($data);
            }
            catch (Exception $e)
            {
                // set response code
                http_response_code(401);

                // show error message
                return json_encode(array(
                    "message" => "Access denied.",
                    "error" => $e->getMessage()));
            }

        }
        else{

            // set response code
            http_response_code(401);

            // tell the user access denied
            return json_encode(array("message" => "Access denied."));
        }
    }

    public function getUserByIdAction($id)
    {
        $headRequest = $this->request->getHeaders();
        $jwt = $headRequest['Jwt'];
        if($jwt)
        {
            try {
                $key  = base64_decode('PhalconDemoApiJWT');
                $decoded = JWT::decode($jwt, $key, array('HS256'));
                $user = Users::findFirst($id);
                return json_encode($user);
            }
            catch (Exception $e)
            {
                // set response code
                http_response_code(401);

                // show error message
                return json_encode(array(
                    "message" => "Access denied.",
                    "error" => $e->getMessage()));
            }

        }
        else{

            // set response code
            http_response_code(401);

            // tell the user access denied
            return json_encode(array("message" => "Access denied."));
        }
    }

}