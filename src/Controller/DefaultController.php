<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {
    
    public function home(Request $request){
        $name = $request->query->get("name");
        $array = ["01" => "Aliquam", "02" => "Tempus", "03" => "Magna", "04" => "Ipsum", "05" => "Consequat", "06" => "Etiam"];
        if(!empty($name)){
            shuffle($array);
        }
        $data = [
            "img" => $array,
        ];
        return $this->render('home/home.html.twig', $data);
    }
    function shuffleArray($name, $array){
        $newArray = [];
        for ($i = 0; $i < count($array); $i++){
            if($array[$i] != $name){
                array_push($newArray, $array[$i]);
            }
            array_rand($newRand);
            array_unshift($newArray, $name);
            return $result;
        }
    }

}