<?php

class User extends Database
{
    public function register_user($first_name, $last_name, $email, $password)
    {
        $sql = "INSERT into users 
        (first_name, last_name, email, password, type) 
        values (:first_name, :last_name, :email, :password, 'user')";

        $info = [":first_name" => $first_name, ":last_name" => $last_name, ":email" => $email, ":password" => $password];

        $this->post_data($sql, $info);
    }

    public function check_user($email, $password)
    {
        $sql = "SELECT * from users where email = :email;";

        $info = [":email" => $email];

        $data = $this->get_data($sql, $info);
        if (count($data) > 0) {
            $user = $data[0];
            $hashed_password = $user["password"];
            return password_verify($password, $hashed_password);
            die();
        }
        return false;
    }

    public function get_user_data($email)
    {
        $sql = "SELECT *
        from users where email = :email;";

        $info = [":email" => $email];

        return $this->get_data($sql, $info)[0];
    }

    public function check_email($email)
    {
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        $sql = "SELECT id from users 
        where email = :email 
        and id != :user_id;";

        $info = [":email" => $email, ":user_id" => $user_id];

        return count($this->get_data($sql, $info)) > 0;
    }

    public function check_phone($phone)
    {
        $sql = "SELECT id from users 
        where phone = :phone
        and id != :user_id
        ";

        $info = [":phone" => $phone, ":user_id" => $_SESSION["user_id"]];

        return count($this->get_data($sql, $info)) > 0;
    }

    public function check_old_password($old_password)
    {
        $sql = "SELECT * from users 
        where id = :user_id;";

        $info = [":user_id" => $_SESSION['user_id']];

        $data = $this->get_data($sql, $info);
        if (count($data) > 0) {
            $user = $data[0];
            $hashed_password = $user["password"];
            return password_verify($old_password, $hashed_password);
            die();
        }
        return false;
    }

    public function edit_user($first_name, $last_name, $email, $phone, $city, $address, $image_name)
    {
        $sql = "UPDATE users 
        set first_name = :first_name,
        last_name = :last_name,
        email = :email,
        phone = :phone,
        city = :city,
        address = :address,
        image_name = :image_name
        where id = :user_id";

        $info = [":first_name" => $first_name, ":last_name" => $last_name, ":email" => $email, ":phone" => $phone, ":city" => $city, ":address" => $address, ":image_name" => $image_name, ":user_id" => $_SESSION['user_id']];

        $this->post_data($sql, $info);
    }

    public function complete_info($city, $address, $phone)
    {
        $sql = "UPDATE users 
        set city = :city,
        address = :address,
        phone = :phone
        where id = :user_id";

        $info = [":city" => $city, ":address" => $address, ":phone" => $phone, ":user_id" => $_SESSION['user_id']];

        $this->post_data($sql, $info);
    }

    public function change_password($password)
    {
        $sql = "UPDATE users 
        set password = :password
        where id = :user_id";

        $info = [":password" => $password, ":user_id" => $_SESSION['user_id']];

        $this->post_data($sql, $info);
    }

    public function update_total_spending($total_spending)
    {
        $sql = "UPDATE users 
        set total_spending = :total_spending
        where id = :user_id
        ";

        $info = [":total_spending" => $total_spending, ":user_id" => $_SESSION['user_id']];

        $this->post_data($sql, $info);
    }

    public function get_all_ids()
    {
        $sql = "SELECT id from users";
        return $this->get_data($sql);
    }
}
