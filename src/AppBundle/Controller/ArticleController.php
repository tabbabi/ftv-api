<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Article;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\Delete;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author marouane
 */
class ArticleController extends FOSRestController
{
    /**
     * Create a Page from the submitted data.
     *
     * @Post("/articles")
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new article from the submitted data.",
     *   input = "AppBundle\Form\ArticleType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @param Request $request
     *
     * @return FormTypeInterface|View
     */
    public function postAction(Request $request)
    {
        $article = $this->get('article.handler')->post($request->request->all());

        return $this->view($article, Response::HTTP_CREATED);
    }

    /**
     * Get single Article.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Article for a given slug",
     *   output = "AppBundle\Entity\Article",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @Get("/articles/{slug}")
     * @ParamConverter("article", options={"slug"})
     */
    public function getAction(Article $article)
    {
        return $this->view($article, Response::HTTP_OK);
    }

    /**
     * List all articles.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Get("/articles")
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing articles.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many articles to return.")
     * @Annotations\View
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAllAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->get('article.handler')->all($limit, $offset);
    }

    /**
     * Delete existing Article.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Delete existing article",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @Delete("/articles/{slug}")
     * @ParamConverter("article", options={"slug"})
     */
    public function deleteAction(Article $article)
    {
        $this->get('article.handler')->remove($article);

        return $this->view('', Response::HTTP_NO_CONTENT);
    }
}
