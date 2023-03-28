<?
namespace providers;
use models\UserModel;
use providers\Provider;

class UserProvider extends Provider
{
    public function addUser(string $name, string $email, string $password)
    {
        if($this->getUserByEmail($email) != null) {
            return null;
        }
        if($this->getUserByUserName($name) != null) {
            return null;
        }
        $query = "INSERT INTO ".$this->getTableName(__CLASS__)." (name, email, password) VALUES ('".$name."', '".$email."', '".$password."')";
        $this->db->prepare($query)->execute();
        return $this->getUserByUserName($name);
    }

    public function getUserByEmail(string $email)
    {
        $query = "SELECT * FROM ".$this->getTableName(__CLASS__)." WHERE email = '". $email ."'";
        $result = $this->db->querySingle($query, true);
        if ($result == null) {
            return null;
        }
        return new UserModel($result['id'], $result['name'], $result['email'], $result['password'], $result['canPublishPosts'] == 1, $result['createdAt']);
    }

    public function getUserByUserName(string $username)
    {
        $query = "SELECT * FROM ".$this->getTableName(__CLASS__)." WHERE name = '". $username ."'";
        $result = $this->db->querySingle($query, true);
        var_dump($result);
        if ($result == null) {
            return null;
        }
        return new UserModel($result['id'], $result['name'], $result['email'], $result['password'], $result['canPublishPosts'], $result['createdAt']);
    }

    public function getUserById(int $id)
    {
        $query = "SELECT * FROM ".$this->getTableName(__CLASS__)." WHERE id = '". $id ."'";
        $result = $this->db->querySingle($query, true);
        if ($result == null) {
            return null;
        }
        return new UserModel($result['id'], $result['name'], $result['email'], $result['password'], $result['canPublishPosts'], $result['createdAt']);
    }

    public function update(int $id, string $name, string $email, string $password, bool $canPublishPosts)
    {
        $query = "UPDATE ".$this->getTableName(__CLASS__)." SET name = :name, email = :email, password = :password, canPublishPosts = :canPublishPosts WHERE id = :id";
        return $this->db->prepare($query)->execute([
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ]);
    }

    public function delete(int $id)
    {
        $query = "DELETE FROM ".$this->getTableName(__CLASS__)." WHERE id = '".$id."'";
        $this->db->prepare($query)->execute();
        return $this->db->lastErrorCode() == 0;
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM ".$this->getTableName(__CLASS__);
        $result = $this->db->query($query);
        $users = [];
        while ($row = $result->fetchArray()) {
            $users[] = new UserModel($row['id'], $row['name'], $row['email'], $row['password'], $row['canPublishPosts'], $row['createdAt']);
        }
        return $users;
    }
}