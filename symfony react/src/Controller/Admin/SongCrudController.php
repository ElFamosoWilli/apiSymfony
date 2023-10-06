<?php

namespace App\Controller\Admin;

use App\Entity\Song;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\File\File;

class SongCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Song::class;
    }
    public function configureActions(\EasyCorp\Bundle\EasyAdminBundle\Config\Actions $actions): Actions 
    {
        return $actions 
        // on redefinie notre boutons d'action de la page index
        ->update(Crud::PAGE_INDEX,Action::NEW,fn(Action $action) => $action->setIcon('fa fa-plus')
        ->setLabel('Ajouter')
        ->setCssClass('btn btn-success'))
        ->update(Crud::PAGE_INDEX,Action::EDIT,fn(Action $action) => $action->setIcon('fa fa-pen')
        ->setLabel('Modifier'))
        ->update(Crud::PAGE_INDEX,Action::DELETE,fn(Action $action) => $action->setIcon('fa fa-trash')
        ->setLabel('Supprimer'))
        ->update(Crud::PAGE_EDIT,Action::SAVE_AND_RETURN,fn(Action $action) => $action -> setLabel('Enregistrer et quitter'))
        ->update(Crud::PAGE_EDIT,Action::SAVE_AND_CONTINUE,fn(Action $action) => $action -> setLabel('Enregistrer et en ajouter un nouveau'))
        ->update(Crud::PAGE_NEW,Action::SAVE_AND_RETURN,fn(Action $action) => $action -> setLabel('Enregistrer et quitter'))
        ->update(Crud::PAGE_NEW,Action::SAVE_AND_ADD_ANOTHER,fn(Action $action) => $action -> setLabel('Enregistrer et en ajouter un nouveau'))
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->update(
            Crud::PAGE_INDEX,
            Action::DETAIL,
            fn (Action $action) => $action
                ->setIcon('fa fa-eye')
                ->setLabel('Voir')
        )
        ->update(
            Crud::PAGE_DETAIL,
            Action::EDIT,
            fn (Action $action) => $action
                ->setIcon('fa fa-pen')
                ->setLabel('Modifier')
        )
        ->remove(
            Crud::PAGE_DETAIL,
            Action::DELETE,
        )
        ->remove(
            Crud::PAGE_INDEX,
            Action::DELETE,
        )
        ->update(
            Crud::PAGE_DETAIL,
            Action::INDEX,
            fn (Action $action) => $action
                ->setIcon('fa fa-list')
                ->setLabel('Retour à la liste')
        );
        
    }
    public function configureCrud(\EasyCorp\Bundle\EasyAdminBundle\Config\Crud $crud): Crud
    {
        return $crud
        ->setPageTitle(Crud::PAGE_INDEX, 'Liste des musiques')
        ->setPageTitle(Crud::PAGE_NEW, 'Ajouter des musiques')
        ->setPageTitle(Crud::PAGE_EDIT, 'Modifier les musiques');


    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title','titre de la chanson'),
            ImageField::new('filePath','Choisir le mp3')
            ->setBasePath('upload/files/music')
            ->setUploadDir('public/upload/files/music')
            ->hideOnIndex()
            ->hideOnDetail(),
            TextField::new('filePath','Aperçu')
            ->hideOnForm()
            ->formatValue(function($value,$entity){
                    return '<audio controls>
                    <source src="/upload/files/music/' . $value . '"type="audio/mpeg">
                    </audio>';
            }),
            NumberField::new('duration','Durée du titre')->hideOnForm(),
            AssociationField::new('album','Album associé'),
            BooleanField::new('isActive','En ligne')
        ];
    }

    // public function configureActions(Actions $actions): Actions
    // {

    // }

    public function getDurationFIle($file)
    {
        $getId3 = new \getID3() ;
        // on récupère le chemin du fichier 
        $basePath = $this->getParameter('kernel.project_dir') . '/public/upload/files/music/' ; 

        $file = new File($basePath . $file); 

        return $getId3->analyze($file)['playtime_seconds'];

    }

    public function persistEntity(\Doctrine\ORM\EntityManagerInterface $entityManagerInterface , $entityInstance ): void 
    {
        if(!$entityInstance instanceof Song)return ;

        $file = $entityInstance->getFilepath();

        $entityInstance->setDuration($this->getDurationFIle($file));

        parent::persistEntity($entityManagerInterface, $entityInstance);
    }
    
}
