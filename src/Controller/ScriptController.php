<?php

namespace App\Controller;

use App\Repository\FieldRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScriptController extends Controller
{
    /**
     * @Route("/script", name="script")
     */
    public function index(FieldRepository $repo)
    {
        $fields = $repo->findBy(
            [],
            ['title' => 'ASC']
        );

        $options = "";
        foreach($fields as $field) {
            $options .= "<option value='{$field->getFieldName()}'>{$field->getTitle()}</option>";
        }

        return $this->render('script/index.html.twig', [
            'options' => $options
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

            $sql[] = $infos->getQuery();

            $render = str_replace("x", $alphabet[$numero], $infos->getRender());

            if($infos->getPlaceholders() == 2) {

                $numero++; 
                $render = str_replace("y", $alphabet[$numero], $render);
            } 

            $textarea = "<textarea name=\"$fieldName\" cols=1 rows=1 style=\"visibility:hidden\">";
            $textarea .= $render;
            $textarea .= "</textarea>";

            $textareas[] = $textarea;


            $numero++;
        }

        $sql = join(",", $sql);

        $textareas = join("\n", $textareas);


        $template = str_replace('{{SQL}}', $sql, $template);

        $template = str_replace('{{TEXTAREAS}}', $textareas, $template);


        file_put_contents('./output.html', $template);
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename("./output.html").'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize("./output.html"));
        flush(); 
        readfile("./output.html");
        exit;
    }
}
