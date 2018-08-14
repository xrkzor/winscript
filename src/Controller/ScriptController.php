<?php

namespace App\Controller;

use App\Entity\Field;
use App\Repository\FieldRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScriptController extends Controller
{
    
    /**
     * @Route("/script", name="script")
     */
    public function index(FieldRepository $repo, Request $request)
    {
        $utilisateur = $this->getUser();
        $version = $utilisateur->getVersion();  
        $type =  $request->request->get('type');

        $fields = $repo->findBy(
            ['version' => $version,
             'type' => $type],
            ['title' => 'ASC']
        );

        $options = "";
        foreach($fields as $field) {
            $options .= "<option value='{$field->getFieldName()}'>{$field->getTitle()}</option>";
        }
        return $this->render('script/script.html.twig', [
            'options' => $options, 'fields' => $fields 
        ]);
    }

    /**
     * @Route("/script/traitement", name="traitement_script")
     */
    public function traitement(Request $request, FieldRepository $repo) {
        $fields = $request->request->get('champs');
        
        $template = file_get_contents('../src/Controller/template.html');

        $sql = []; 

        $textareas = []; 

        $alphabet = "abcdefghijklmnopq";

        $numero = 0;

        foreach($fields as $fieldName) {
            if(empty($fieldName)) continue;

            $infos = $repo->findOneByFieldName($fieldName);

            if(!$infos){
                $query = $fieldName;
                $render = "~?x~";
            } else {
                $query = $infos->getQuery();
                $render = $infos->getRender();
            }

            $sql[] = $query;
            
            $render = str_replace("x", $alphabet[$numero], $render);

            if($infos && $infos->getPlaceholders() == 2) {
                $numero++; 
                $render = str_replace("y", $alphabet[$numero], $render);
            } 

            $textarea = "<textarea name=\"$fieldName\" cols=1 rows=1 style=\"visibility:hidden\">$render</textarea>";
         

            $textareas[] = $textarea;


            $numero++;
        }

        $sql = implode(", ", $sql);

        $textareas = join("\n", $textareas);


        $template = str_replace('{{SQL}}', $sql, $template);

        $template = str_replace('{{TEXTAREAS}}', $textareas, $template);


        file_put_contents('./titres_web.html', $template);
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename("./titres_web.html").'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize("./titres_web.html"));
        flush();

        readfile("./titres_web.html");
        exit;
    }

}
