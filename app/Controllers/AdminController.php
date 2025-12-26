<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ChapterModel;
use App\Models\MonsterModel;
use App\Models\ItemModel;
use App\Models\ClassModel;
use App\Models\LevelModel;

class AdminController {
    public function show(): void {
        // Handle deletes first
        if (isset($_POST['delete_monster'])) {
            (new MonsterModel())->delete((int)$_POST['delete_monster']);
            header('Location: ' . base_url('/admin'));
            exit;
        }
        if (isset($_POST['delete_item'])) {
            (new ItemModel())->delete((int)$_POST['delete_item']);
            header('Location: ' . base_url('/admin'));
            exit;
        }
        if (isset($_POST['delete_user'])) {
            (new UserModel())->delete((int)$_POST['delete_user']);
            header('Location: ' . base_url('/admin'));
            exit;
        }
        if (isset($_POST['delete_chapter'])) {
            (new ChapterModel())->delete((int)$_POST['delete_chapter']);
            header('Location: ' . base_url('/admin'));
            exit;
        }
        if (isset($_POST['delete_class'])) {
            (new ClassModel())->deleteClass((int)$_POST['delete_class']);
            header('Location: ' . base_url('/admin'));
            exit;
        }
        if (isset($_POST['delete_level'])) {
            (new LevelModel())->delete((int)$_POST['delete_level']);
            header('Location: ' . base_url('/admin'));
            exit;
        }
        
        $choix = $_POST['choix'] ?? null;
        $users = [];
        $chapters = [];
        $monsters = [];
        $items = [];
        $classes = [];
        $levels = [];
        
        try {
            switch ($choix) {
                case 'users':
                    $users = (new UserModel())->getAllUsers() ?? [];
                    break;
                case 'chapters':
                    $chapters = (new ChapterModel())->getAllChapters() ?? [];
                    break;
                case 'monsters':
                    $monsters = (new MonsterModel())->getAllMonsters() ?? [];
                    break;
                case 'items':
                    $items = (new ItemModel())->getAll() ?? [];
                    break;
                case 'class':
                    $classes = (new ClassModel())->getAllClasses() ?? [];
                    break;
                case 'level':
                    $levels = (new LevelModel())->getAll() ?? [];
                    break;
            }
        } catch (\Throwable $e) {
            die('Admin Error: ' . $e->getMessage());
        }
        
        require __DIR__ . '/../Views/admin.php';
    }
    

    public function delete(): void {
        if (isset($_POST['delete_monster'])) {
            (new MonsterModel())->delete((int)$_POST['delete_monster']);
        }
        if (isset($_POST['delete_item'])) {
            (new ItemModel())->delete((int)$_POST['delete_item']);
        }
        if (isset($_POST['delete_class'])) {
            (new ClassModel())->deleteClass((int)$_POST['delete_class']);
        }
        if (isset($_POST['delete_level'])) {
            (new LevelModel())->delete((int)$_POST['delete_level']);
        }
        header('Location: ' . base_url('/admin'));
        exit;
    }
}