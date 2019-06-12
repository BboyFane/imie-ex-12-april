<?php
    namespace App\Controller;

    use App\Entity\User;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

    class UserController extends AbstractController {
        
        public function register(Request $request){
            // Verifying the syntax of the email 
            if(!filter_var( $request->get("email"), FILTER_VALIDATE_EMAIL ))
                return $this->returnJson(["Invalid email syntax"], 403);

            $er = $this->getDoctrine()->getRepository(User::class);
            $theUser = $er->findOneBy(["email" => $request->get("email")]);
            if(!$theUser){
                $em = $this->getDoctrine()->getManager();
                $user = new User($request->get("name"), $request->get("email"));
                $user->setPassword($encodePass->encodePassword($user, $request->get("password")));
                try{
                    $em->persist($user);
                    $em->flush();
                }catch(Doctrine\ORM\EntityNotFoundException $e){
                    return $this->returnJson([$e->getMessage], 403);
                }

            }else
                return $this->returnJson(["Email already exists"], 403);
            // return $this->render('home/register.html.twig');
        }

        public function getLogin(){
            return $this->redirectToRoute('index');
        }

        public function login(AuthenticationUtils $authenticationUtils) {
            $error = $authenticationUtils->getLastAuthenticationError();
            $email = $authenticationUtils->getLastUsername();
            dd($error);
            return $this->render('home/register.html.twig');
        }

        /**
         * Return the answer in JSON format
         * @param $data[] - Data type array
         * @param $status - Data type int
         * @return Response
         */
        private function returnJson($data, $status = 200){
            return new Response(json_encode($data), $status, ["Content-Type" => "application/json"]);
        }

    }