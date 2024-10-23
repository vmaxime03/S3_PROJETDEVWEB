<?php

namespace iutnc\deefy\action;

class AddUserAction extends Action
{

    public function get(): string
    {
        return <<<END
       <form action="?action=add-user" method="POST">
            <input type="text" name="userName" placeholder="nom">
            <input type="email" name="userEmail" placeholder="email">
            <input type="number" name="userAge" placeholder="age">
            <input type="submit" value="Confirmer">
        </form> 
       END;
    }

    public function post(): string
    {


        if (!(isset($_POST['userName']) && isset($_POST['userEmail']) && isset($_POST['userAge'])) ||
            $_POST['userName'] == "" || $_POST['userEmail'] == "" || $_POST['userAge'] == "") {
            return "entrée manquante";
        }

        if ((isset($_SESSION["userName"]) && $_SESSION["userName"] === $_POST['userName']) &&
            (isset($_SESSION["userEmail"]) && $_SESSION["userEmail"] === $_POST['userEmail']) &&
            (isset($_SESSION["userAge"]) && $_SESSION["userAge"] === $_POST['userAge']))
        {
            return "Welcome back " . $_SESSION["userName"];
        }


        if (($_POST["userName"] === filter_var($_POST["userName"], FILTER_SANITIZE_STRING)) &&
            ($_POST["userEmail"] === filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL)) &&
            ($_POST["userAge"] === filter_var($_POST["userAge"], FILTER_SANITIZE_NUMBER_INT)))
        {
            $_SESSION["userName"] = $_POST['userName'];
            $_SESSION["userEmail"] = $_POST['userEmail'];
            $_SESSION["userAge"] = $_POST['userAge'];
            return "Welcome " . $_SESSION["userName"];
        } else {
            return "entree invalide";
        }


    }
}