<?php

namespace AppBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;

/**
 * @author marouane
 */
class ArticleHandler
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @param ObjectManager        $om
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(ObjectManager $om, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->formFactory = $formFactory;
    }

    /**
     * Create a new Article.
     *
     * @param array $parameters
     *
     * @return Article
     */
    public function post(array $parameters)
    {
        $article = $this->createArticle();

        return $this->processForm($article, $parameters, 'POST');
    }

    /**
     * Get a list of Articles.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->getRepository()->findBy(array(), null, $limit, $offset);
    }

    /**
     * Remove article.
     *
     * @param Article $article
     */
    public function remove(Article $article)
    {
        $this->om->remove($article);
        $this->om->flush();
    }

    /**
     * Processes the form.
     *
     * @param Article $article
     * @param array   $parameters
     * @param string  $method
     *
     * @return Article
     *
     * @throws \Exception
     */
    private function processForm(Article $article, array $parameters, $method)
    {
        $form = $this->formFactory->create(new ArticleType(), $article, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {
            $this->om->persist($article);
            $this->om->flush();

            return $article;
        }

        throw new \Exception('Invalid submitted data', 400);
    }

    /**
     * Create new Article.
     *
     * @return \AppBundle\Entity\Article
     */
    private function createArticle()
    {
        return new Article();
    }

    /**
     * Get article Repository.
     */
    private function getRepository()
    {
        return $this->om->getRepository('AppBundle:Article');
    }
}
