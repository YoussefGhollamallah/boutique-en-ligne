<?php

class ModelUtilisateur 
{
    private $connexion;

    public function __construct(){
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function addUser($prenom, $nom, $email, $password, $id_adresse = null, $role_id = 2)
    {
        try {
            // Vérification de l'existence de l'email
            if ($this->emailExists($email)) {
                throw new Exception("Cet email est déjà utilisé.");
            }
    
            // Insertion de l'utilisateur
            $requete = $this->connexion->prepare("INSERT INTO Utilisateur (id, prenom, nom, email, mot_de_passe, id_adresse, role_id) VALUES (null, ?, ?, ?, ?, ?, ?)");
            $requete->execute([$prenom, $nom, $email, $password, $id_adresse, $role_id]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
        }
    }
    

    public function userConnexion($email, $password)
{
    try {
        $requete = $this->connexion->prepare("SELECT * FROM Utilisateur WHERE email = :email");
        $requete->bindParam(':email', $email);
        $requete->execute();
        $user = $requete->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            // Stocke l'identifiant de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            return $user;
        } else {
            return false;
        }
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la connexion de l'utilisateur : " . $e->getMessage());
    }
}


    public function getAllUsers()
    {
        try{
            $requete = $this->connexion->prepare("SELECT * FROM Utilisateur 
            INNER JOIN Role ON Utilisateur.role_id = Role.id_role");
            $requete->execute();
            $result = $requete->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
        }
    }

    public function getRoles()
    {
        try{
            $requete = $this->connexion->prepare("SELECT * FROM Role");
            $requete->execute();
            $result = $requete->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des rôles : " . $e->getMessage());
        }
    }

    public function updateUser($userId, $nom, $prenom, $email, $role_id)
    {
        try {
            $requete = $this->connexion->prepare("UPDATE Utilisateur SET nom = :nom, prenom = :prenom, email = :email, role_id = :role_id WHERE id = :id");
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':email', $email);
            $requete->bindParam(':role_id', $role_id);
            $requete->bindParam(':id', $userId);
            $requete->execute();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
        }
    }

    public function emailExists($email)
{
    try {
        $requete = $this->connexion->prepare("SELECT COUNT(*) FROM Utilisateur WHERE email = :email");
        $requete->bindParam(':email', $email);
        $requete->execute();
        $count = $requete->fetchColumn();
        
        return $count > 0;
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la vérification de l'existence de l'email : " . $e->getMessage());
    }
}

    public function resetPassword($email, $password)
    {
        try {
            $requete = $this->connexion->prepare("UPDATE Utilisateur SET mot_de_passe = :password WHERE email = :email");
            $requete->bindParam(':password', $password);
            $requete->bindParam(':email', $email);
            $result = $requete->execute();
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la réinitialisation du mot de passe : " . $e->getMessage());
        }
    }

    public function deleteUserById(int $id):void
    {
        try {
            $this->deleteAdressesByUserId($id);

            $requete = $this->connexion->prepare("DELETE FROM Utilisateur WHERE id = :id");
            $requete->bindParam(':id', $id, PDO::PARAM_INT);
            $requete->execute();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
        }
    }

    
    public function deleteAdressesByUserId(int $userId): void
    {
        try {
            $requete = $this->connexion->prepare("DELETE FROM Adresse WHERE id_utilisateur = :id_utilisateur");
            $requete->bindParam(':id_utilisateur', $userId, PDO::PARAM_INT);
            $requete->execute();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression des adresses : " . $e->getMessage());
        }
    }


}