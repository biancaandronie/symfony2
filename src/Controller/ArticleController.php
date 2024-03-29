<?php

namespace App\Controller;

use App\Service\MarkdownHelp;
use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ArticleController extends AbstractController
{
    private $isDebug;

    public function __construct($isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/article", name="article")
     */
    public function show()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/home/{slug}", name="home")
     */
    public function test($slug, MarkdownHelp $help){

        $articleContent = <<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
turkey shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork **belly aliquip** capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
**cow** est ribeye adipisicing. Pig [hamburger](www.hamburger.com) pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF;

        $articleContent = $help->parse($articleContent);

        $comments = ['ana','bia'];
        return $this->render('article/continut.html.twig',[
            'title' => ucwords(str_replace('-',' ',$slug)),
            'articleContent' => $articleContent,
            'slug' => $slug,
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/home/{slug}/heart", name="toggle_article", methods={"POST"})
     */
    public function toggleArticle($slug, LoggerInterface $logger){
        //TODO
        $logger->info('text');
        return new JsonResponse(['hearts'=>rand(5,100)]);
    }

}
