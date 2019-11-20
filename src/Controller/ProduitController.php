<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitController extends AbstractController
{
   /**
     * @Route("/", name="Produits")
     */
    public function index()
    {
          //JE VAIS CHERCHER LE REPOSITORY
          $repository=$this->getDoctrine()->getRepository(Produit::class);

          //je fais un select *
          $Produits=$repository->findALL();
  
          return $this->render('Produits/index.html.twig', [
              "Produits"=>$Produits
          ]);
    }
    /**
     * @Route("/Produits/ajouter", name="Produit_ajouter")
     */
    public function ajouter(Request $request)
    {
        //je crée un objet catégorie vide
        $Produit=new Produit();

        //créer le formulaire
        $formulaire=$this->createForm(ProduitType::Class, $Produit);//créer un formulaire vide

        $formulaire->handleRequest($request);
        
    /* if (strlen($EAN)== 14){
        $EAN[13]=array($EAN[1]*3,$EAN[2],$EAN[3]*3,$EAN[4],$EAN[5]*3,$EAN[6],$EAN[7]*3,$EAN[8],$EAN[9]*3,$EAN[10],$EAN[11]*3,$EAN[12],$EAN[13]*3);
        $total=$EAN[14]*10; 
        $calule=$EAN[1]+$EAN[2]+$EAN[3]+$EAN[4]+$EAN[5]+$EAN[6]+$EAN[7]+$EAN[8]+$EAN[9]+$EAN[10]+$EAN[11]+$EAN[12]+$EAN[13];
        var_dump ("EAN 14 =="+$calule);
        var_dump ("EAN 14 =="+$total);
        $dif=$toal-$calule;
        $dif==$EAN[14];

        if (strlen($EAN)== 13){
            $EAN[12]=array($EAN[1]*3,$EAN[2],$EAN[3]*3,$EAN[4],$EAN[5]*3,$EAN[6],$EAN[7]*3,$EAN[8],$EAN[9]*3,$EAN[10],$EAN[11]*3,$EAN[12]);
            $total=$EAN[14]*10; 
            $calule=$EAN[1]+$EAN[2]+$EAN[3]+$EAN[4]+$EAN[5]+$EAN[6]+$EAN[7]+$EAN[8]+$EAN[9]+$EAN[10]+$EAN[11]+$EAN[12]+$EAN[13];
            var_dump ("EAN 13 =="+$calule);
            var_dump ("EAN 13 =="+$total);
            $dif=$toal-$calule;
            $dif==$EAN[14];
        }
     }*/
    

        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //recuperation de l'entity manager
            $em=$this->getDoctrine()->getManager();
            // je dis ou manager de garder cet objet en BDD
            $em->persist($Produit);
            //execute l'insert
            $em->flush();

            //je m'en vais
          return  $this->redirectToRoute("Produits");
        }

        return $this->render('Produits/formulaire.html.twig',[
            "formulaire"=>$formulaire->createView()
            ,"h1"=>"Ajouter un Produit"
        ]);
        }
    

    /**
     * @Route("/Produits/modifier/{id}", name="Produit_modifier")
     */
    public function modifier(Request $request, $id)
    {
        $repository=$this->getDoctrine()->getRepository(Produit::class);
        $Produit=$repository->find($id);
 
         //créer le formulaire
         $formulaire=$this->createForm(ProduitType::Class, $Produit);//créer un formulaire vide
 
         $formulaire->handleRequest($request);
 
         if ($formulaire->isSubmitted() && $formulaire->isValid()){
             //recuperation de l'entity manager
             $em=$this->getDoctrine()->getManager();
             // je dis ou manager de garder cet objet en BDD
             $em->persist($Produit);
             //execute l'update
             $em->flush();
 
             //je m'en vais
           return  $this->redirectToRoute("Produits");
         }
 
         return $this->render('Produits/formulaire.html.twig',[
             "formulaire"=>$formulaire->createView()
             ,"h1"=>"Modifier le Produit "
         ]);
    }


       /**
     * @Route("/Produits/supprimer/{id}", name="Produit_supprimer")
     */
    public function supprimer(Request $request, $id)
    {
        $repository=$this->getDoctrine()->getRepository(Produit::class);
        $Produit=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Produit);
        $em->flush();
        return  $this->redirectToRoute("Produits");

    }
}
