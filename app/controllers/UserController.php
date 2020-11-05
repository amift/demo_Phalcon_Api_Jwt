<?php


use Firebase\JWT\JWT;
use Phalcon\Http\Response;


class UserController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function registerAction()
    {
        $user = new Users();
        $user->name = $this->request->getPost('name');
        $user->email = $this->request->getPost('email');
        $user->phone = $this->request->getPost('phone');
        $user->password = $this->security->hash($this->request->getPost("password"));
        try {
            $user->save();
            // Create a response
            $response = new Response();
            $response->setStatusCode(201, 'Created');
            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $user,
                ]
            );
            return $response;
        }
        catch (Exception $e)
        {
            return "Message: ". $e;
        }
    }

    public function loginAction()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = Users::findFirstByEmail($email);
        if($user)
        {
            if($this->security->checkHash($password, $user->password))
            {
                $key  = base64_decode('PhalconDemoApiJWT');
                $time = time();
                $expires = $time;
                $token = [
                    'iss' =>  $this->request->getURI(),
                    'iat' =>  $time,
                    'exp' =>  $expires + 86400,
                    'data' =>[
                        'id' => $user->id,
                        'email' => $user->email,
                    ]
                ];

                // set response code
                http_response_code(200);

                // generate jwt
                $jwt = JWT::encode($token, $key);

                return json_encode(
                    array(
                        "message" => "Successful login.",
                        "jwt" => $jwt
                    )
                );
            }
            else
            {
                return "Password Wrong";
            }
        }
        else
        {
            return "Account does not exist";
        }
    }

    public function editAction($id)
    {
        $headRequest = $this->request->getHeaders();
        $jwt = $headRequest['Jwt'];
        if($jwt)
        {
            try {
                $key  = base64_decode('PhalconDemoApiJWT');
                $decoded = JWT::decode($jwt, $key, array('HS256'));

                if($id == $decoded->data->id)
                {
                    $user = Users::findFirst($id);
                    $user->name = $this->request->getPost('name');
                    $user->phone = $this->request->getPost('phone');
                    $user->password = $this->request->getPost('password');
                    try {
                        $user->save();
                        // Create a response
                        $response = new Response();
                        $response->setStatusCode(201, 'Created');
                        $response->setJsonContent(
                            [
                                'status' => 'Update Success!!!',
                                'data'   => $user,
                            ]
                        );
                        return $response;
                    }
                    catch (Exception $e)
                    {
                        return "Message: ". $e;
                    }

                }
                else
                {
                    return "Message: Access denied!!";
                }
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