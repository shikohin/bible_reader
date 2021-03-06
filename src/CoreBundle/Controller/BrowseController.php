<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EntityBundle\Entity\Book;
use EntityBundle\Entity\Chapter;
use Symfony\Component\HttpFoundation\Request;


/**
* @Route("/browse")
*/
class BrowseController extends Controller
{
    /**
     * Lists all books
     * @Route("/", name="BookIndex")
     */
    public function bookAction()
    {    	
    	$books = $this->getDoctrine()
    				  ->getManager()
    				  ->getRepository('EntityBundle:Book')
    				  ->findAll();

        return $this->render('CoreBundle:Browse:book.html.twig', compact('books'));
    }

    /**
     * Lists all chapters for a given book
     * @Route("/{book}", name="ChaptersIndex", requirements={"book": "\d?\D+$"})
     */
    public function chaptersAction(Request $req)
    {
    	$book_name = $req->attributes
    					 ->get('book');

    	$book = $this->getDoctrine()
    				 ->getManager()
    				 ->getRepository('EntityBundle:Book')
    				 ->getBookVerses($book_name);    	

    	if (!$book) 
    	{
    		throw $this->createNotFoundException('Book not found');    		
    	}   	

        return $this->render('CoreBundle:Browse:chapter.html.twig', compact('book'));
    }    
}
