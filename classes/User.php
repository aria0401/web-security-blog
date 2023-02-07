<?php


class User {

    public $id;

    /** Validate all the data in the $_POST[] super global array */
    public function validate() {
        // in sign-up, login, forgot-password, reset-password, edit-profile

        $minLenght = 2;
        $maxLenght = 15;

        if (isset($this->firstname) && $this->firstname == '') {
            $this->errors[] = 'First name is required';
        }

        if (isset($this->lastname) && $this->lastname == '') {
            $this->errors[] = 'Last name is required';
        }

        if (isset($this->username) && $this->username == '') {
            $this->errors[] = 'Username is required';
        }

        if (isset($this->description) && $this->description == '') {
            $this->errors[] = 'Description is required';
        }

        if (isset($this->email)) {
            if ($this->email == '') {
                $this->errors[] = 'Email is required';
            }
            if (!$this->email == '' && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = 'Email is invalid';
            }
        }

        if (isset($this->password) && $this->password == '') {

            $this->errors[] = 'Password is required';
        } else {
            if (!$this->password == '') {
                if (strlen($this->password) < $minLenght) {
                    $this->errors[] = 'Password should have at least ' . $minLenght . ' characters';
                }
                if (strlen($this->password) > $maxLenght) {
                    $this->errors[] = 'Password should have max ' . $maxLenght . ' characters';
                }
            }
        }

        if (isset($this->newPassword) && isset($this->confirmPassword)) {

            if ($this->newPassword == '') {
                $this->errors[] = 'New password is required';
            } else {
                if (strlen($this->newPassword) < $minLenght) {
                    $this->errors[] = 'Password should have at least ' . $minLenght . ' characters';
                }
                if (strlen($this->newPassword) > $maxLenght) {
                    $this->errors[] = 'Password should have max ' . $maxLenght . ' characters';
                }
            }

            if ($this->confirmPassword == '') {
                $this->errors[] = 'Confirm password is required';
            }

            if (!$this->newPassword == '' && !$this->confirmPassword == '') {

                if ($this->newPassword !== $this->confirmPassword) {
                    $this->errors[] = 'New password and Confirm password do not match';
                }
            }
        }


        return empty($this->errors);
    }

    /** Select user where email matches and return true is succesfull */
    public function authenticateEmail($conn) {
        // in sign-up, forgot-password

        $sql = "SELECT * FROM users WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();

        if ($stmt->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    /** Insert new user in db with a hashed password and a verification key */
    public function create($conn) {
        // in sign-up.php

        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, email, password, verification_key, forgot_password_key)
                    VALUES(:first_name, :last_name, :email, :password, :verification_key, :forgot_password_key)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':first_name', $this->firstname, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $this->lastname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindValue(':verification_key', $this->verification_key, PDO::PARAM_STR_CHAR);
        $stmt->bindValue(':forgot_password_key', $this->forgot_password_key, PDO::PARAM_STR_CHAR);

        if ($stmt->execute()) {
            $this->id = $conn->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    /** Select user in daba where verification_key matches and return user as assoc array */
    public function verifyKey($conn, $verification_key) {
        //in validate-user.php

        $sql = "SELECT * FROM users WHERE verification_key = :verification_key";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':verification_key', $verification_key, PDO::PARAM_STR_CHAR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $user = $stmt->fetch();
        return $user;
    }

    /** Update users, set verified to 1 where the user id matches */
    public function verified($conn, $id) {
        //in validate-user.php

        $sql = "UPDATE users SET verified = 1 WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
    }

    /** Select user in db where email matches and return the verified password */
    public function authenticateLogin($conn, $password) {
        // in login.php

        $sql = "SELECT * FROM users WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();

        if ($user = $stmt->fetch()) {
            return password_verify($password, $user->password);
        }
    }

    /** Check if the user has verified her account */
    public function checkVerified($conn) {
        // in login.php

        $sql = "SELECT * FROM users WHERE email = :email AND verified = 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();

        if ($stmt->fetch()) {
            return true;
        }
    }

    /** Update users, set new forgot_password_key where email matches */
    public function updateForgotPasswordKey($conn) {
        // in forgot-password.php

        $sql = "UPDATE users SET forgot_password_key = :forgot_password_key
                    WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':forgot_password_key', $this->forgot_password_key, PDO::PARAM_STR_CHAR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }
    }

    /** Select user where forgot_password_key matches and return user email */
    public function authenticateKey($conn) {
        // in reset-password.php

        $sql = "SELECT * FROM users WHERE forgot_password_key = :forgot_password_key";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':forgot_password_key', $this->forgot_password_key, PDO::PARAM_STR_CHAR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();

        if ($user = $stmt->fetch()) {
            return $user->email;
        } else {
            return false;
        }
    }

    /** Update users, set new hashed password where forgot_password_key matches */
    public function updatePassword($conn) {
        // in reset-password.php

        $hashed_password = password_hash($this->newPassword, PASSWORD_DEFAULT);
        $new_forgot_password_key = bin2hex(random_bytes(8));

        $sql = "UPDATE users SET password = :password, forgot_password_key = :new_forgot_password_key
                    WHERE forgot_password_key = :old_forgot_password_key";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':old_forgot_password_key', $this->forgot_password_key, PDO::PARAM_STR_CHAR);
        $stmt->bindValue(':new_forgot_password_key', $new_forgot_password_key, PDO::PARAM_STR_CHAR);
        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }
    }


    /** Update users, set new email and password where id matches */
    public function updateLogin($conn) {
        // in edit-profile.php

        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET email = :email,  password = :password
                    WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
    }


    /** Update users, set username and description where id matches */
    public function updateProfile($conn) {
        // in create-profile.php
        $sql = "UPDATE users SET username = :username, description = :description, has_profile = 1
        WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
    }

    /** * Select user where email matches and return an user object */
    public static function getByEmail($conn, $email, $columns = '*') {
        // in: forgot-password, login

        $sql = "SELECT $columns
                FROM users
                WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        if ($stmt->execute()) {

            return $stmt->fetch();
        }
    }

    /** * Select user where id matches and return an user object */
    public static function getById($conn, $id, $columns = '*') {
        // in edit-profile

        $sql = "SELECT $columns
                FROM users
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        if ($stmt->execute()) {

            return $stmt->fetch();
        }
    }
}
