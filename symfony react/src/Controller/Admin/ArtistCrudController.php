<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArtistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artist::class;
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
        ->update(Crud::PAGE_NEW,Action::SAVE_AND_ADD_ANOTHER,fn(Action $action) => $action -> setLabel('Enregistrer et en ajouter un nouveau'))            ->add(Crud::PAGE_INDEX, Action::DETAIL)
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
        ->update(
            Crud::PAGE_DETAIL,
            Action::DELETE,
            fn (Action $action) => $action
                ->setIcon('fa fa-trash')
                ->setLabel('Supprimer')
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
        ->setPageTitle(Crud::PAGE_INDEX, 'Liste des artistes')
        ->setPageTitle(Crud::PAGE_NEW, 'Ajouter des artistes')
        ->setPageTitle(Crud::PAGE_EDIT, 'Modifier les artistes');


    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
