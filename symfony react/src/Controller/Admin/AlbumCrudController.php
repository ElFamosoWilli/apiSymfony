<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AlbumCrudController extends AbstractCrudController
{
    public const ALBUM_BASE_PATH = '/upload/images/albums';
    public const ALBUM_UPLOAD_DIR = 'public/upload/images/albums';

    public function __toString(){
        return $this::class ;
    }
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    public function configureCrud(\EasyCorp\Bundle\EasyAdminBundle\Config\Crud $crud): Crud
    {
        return $crud
        ->setPageTitle(Crud::PAGE_INDEX, 'Liste des albums')
        ->setPageTitle(Crud::PAGE_NEW, 'Ajouter des albums')
        ->setPageTitle(Crud::PAGE_EDIT, 'Modifier les albums');


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
            Action::DELETE
        )
        ->remove(
            Crud::PAGE_INDEX,
            Action::DELETE
        )
        ->update(
            Crud::PAGE_DETAIL,
            Action::INDEX,
            fn (Action $action) => $action
                ->setIcon('fa fa-list')
                ->setLabel('Retour à la liste')
        );
        
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title','Titre de l\'album'),
            AssociationField::new('genre','Catégorie de l\'album'),
            AssociationField::new('artist','Artiste'),
            ImageField::new('image_path', 'image de l\'album')
            ->setBasePath(self::ALBUM_BASE_PATH)
            ->setUploadDir(self::ALBUM_UPLOAD_DIR)
            ->setUploadedFileNamePattern(
                fn(UploadedFile $file):string => sprintf(
                    'uploaded_%d_%s.%s',
                    random_int(1,999),
                    $file->getFilename(),
                    $file->guessExtension()
                )
            ),
            DateTimeField::new('releaseDate','Date de sortie'),
            IntegerField::new('createdAt')->hideOnForm(),
            IntegerField::new('updatedAt')->hideOnForm(),
            AssociationField::new('songs','Nombre de pistes')->hideOnForm(),
            BooleanField::new('isActive','En ligne')

        ];
    }
    
    public function persistEntity(\Doctrine\ORM\EntityManagerInterface $entityManagerInterface, $entityInstance) : void
    {
        if(!$entityInstance instanceof Album) return ;
        $entityInstance->setCreatedAt(time());
        parent::persistEntity($entityManagerInterface, $entityInstance); 
    }

    public function updateEntity(\Doctrine\ORM\EntityManagerInterface $entityManagerInterface , $entityInstance ):void
    {
        if(!$entityInstance instanceof Album) return ; 
        $entityInstance->setUpdatedAt(time());
        parent::updateEntity($entityManagerInterface,$entityInstance);
     }
}
