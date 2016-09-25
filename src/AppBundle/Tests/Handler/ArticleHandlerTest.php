<?php

namespace AppBundle\Tests\Handler;

use AppBundle\Handler\ArticleHandler;
use AppBundle\Entity\Article;

/**
 * @author nour
 */
class ArticleHandlerTest extends \PHPUnit_Framework_TestCase
{
    const Article_CLASS = 'AppBundle\Tests\Handler\DummyArticle';

    protected $handler;

    protected $om;

    protected $formFactory;

    protected $repository;

    public function setUp()
    {
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $this->handler = new ArticleHandler($this->om, $this->formFactory);
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo('AppBundle:Article'))
            ->will($this->returnValue($this->repository));
    }

    public function testGetAll()
    {
        $offset = 1;
        $limit = 5;
        $articles = $this->getArticles($limit);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($articles));

        $this->handler = new ArticleHandler($this->om, $this->formFactory);
        $list = $this->handler->all($limit, $offset);

        $this->assertEquals($articles, $list);
    }

    public function testPost()
    {
        $title = 'title 1';
        $leading = 'leading 1';
        $body = 'body 1';
        $createdBy = 'toto';
        $parameters = ['title' => $title, 'leading' => $leading, 'body' => $body, 'createdBy' => $createdBy];
        $article = $this->getArticle();
        $article->setTitle($title);
        $article->setLeading($leading);
        $article->setBody($body);
        $article->setCreatedBy($createdBy);

        $form = $this->getMock('Symfony\Component\Form\FormInterface');
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->handler = new ArticleHandler($this->om, $this->formFactory);
        $object = $this->handler->post($parameters);
//        $this->assertEquals($object, $article);
    }

    protected function getArticle()
    {
        $articleClass = self::Article_CLASS;

        return new $articleClass();
    }
    protected function getArticles($maxArticles = 5)
    {
        $articles = array();
        for ($i = 0; $i < $maxArticles; ++$i) {
            $articles[] = $this->getArticle();
        }

        return $articles;
    }
}
