<?php
session_start();
ini_set('display_errors', 1);

class Action {
    private $db;

    public function __construct() {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }

    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    // Login Methods
    function login() {
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM users WHERE username = '$username' AND password = '" . md5($password) . "'");
        if ($qry->num_rows > 0) {
            foreach ($qry->fetch_array() as $key => $value) {
                if ($key != 'password' && !is_numeric($key))
                    $_SESSION['login_' . $key] = $value;
            }
            return 1;
        } else {
            return 3;
        }
    }

    function login2() {
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM complainants WHERE email = '$email' AND password = '" . md5($password) . "'");
        if ($qry->num_rows > 0) {
            foreach ($qry->fetch_array() as $key => $value) {
                if ($key != 'password' && !is_numeric($key))
                    $_SESSION['login_' . $key] = $value;
            }
            return 1;
        } else {
            return 3;
        }
    }

    // Logout Methods
    function logout() {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location: login.php");
    }

    function logout2() {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location: ../index.php");
    }

    // User Management Methods
    function save_user() {
        extract($_POST);
        $data = " name = '$name' ";
        $data .= ", username = '$username' ";
        if (!empty($password))
            $data .= ", password = '" . md5($password) . "' ";
        $data .= ", type = '$type' ";
        if ($type == 1)
            $establishment_id = 0;
        $data .= ", establishment_id = '$establishment_id' ";
        $chk = $this->db->query("SELECT * FROM users WHERE username = '$username' AND id != '$id' ")->num_rows;
        if ($chk > 0) {
            return 2;
            exit;
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO users SET $data");
        } else {
            $save = $this->db->query("UPDATE users SET $data WHERE id = $id");
        }
        if ($save) {
            return 1;
        }
    }

    function delete_user() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM users WHERE id = $id");
        if ($delete)
            return 1;
    }

    // Signup Method
    function signup() {
        extract($_POST);
        $data = " name = '$name' ";
        $data .= ", email = '$email' ";
        $data .= ", address = '$address' ";
        $data .= ", contact = '$contact' ";
        $data .= ", password = '" . md5($password) . "' ";
        $chk = $this->db->query("SELECT * FROM complainants WHERE email = '$email' " . (!empty($id) ? " AND id != '$id' " : ''))->num_rows;
        if ($chk > 0) {
            return 3;
            exit;
        }
        if (empty($id))
            $save = $this->db->query("INSERT INTO complainants SET $data");
        else
            $save = $this->db->query("UPDATE complainants SET $data WHERE id = $id");
        if ($save) {
            if (empty($id))
                $id = $this->db->insert_id;
            $qry = $this->db->query("SELECT * FROM complainants WHERE id = $id");
            if ($qry->num_rows > 0) {
                foreach ($qry->fetch_array() as $key => $value) {
                    if ($key != 'password' && !is_numeric($key))
                        $_SESSION['login_' . $key] = $value;
                }
                return 1;
            } else {
                return 3;
            }
        }
    }

    // Update Account Method
    function update_account() {
        extract($_POST);
        $data = " name = '" . $firstname . ' ' . $lastname . "' ";
        $data .= ", username = '$email' ";
        if (!empty($password))
            $data .= ", password = '" . md5($password) . "' ";
        $chk = $this->db->query("SELECT * FROM users WHERE username = '$email' AND id != '{$_SESSION['login_id']}' ")->num_rows;
        if ($chk > 0) {
            return 2;
            exit;
        }
        $save = $this->db->query("UPDATE users SET $data WHERE id = '{$_SESSION['login_id']}'");
        if ($save) {
            $data = '';
            foreach ($_POST as $k => $v) {
                if ($k == 'password')
                    continue;
                if (empty($data) && !is_numeric($k))
                    $data = " $k = '$v' ";
                else
                    $data .= ", $k = '$v' ";
            }
            if ($_FILES['img']['tmp_name'] != '') {
                $fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
                $move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
                $data .= ", avatar = '$fname' ";
            }
            $save_alumni = $this->db->query("UPDATE alumnus_bio SET $data WHERE id = '{$_SESSION['bio']['id']}'");
            if ($data) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                $login = $this->login2();
                if ($login)
                    return 1;
            }
        }
    }

    // Settings Management Method
    function save_settings() {
        extract($_POST);
        $data = " name = '" . str_replace("'", "&#x2019;", $name) . "' ";
        $data .= ", email = '$email' ";
        $data .= ", contact = '$contact' ";
        $data .= ", about_content = '" . htmlentities(str_replace("'", "&#x2019;", $about)) . "' ";
        if ($_FILES['img']['tmp_name'] != '') {
            $fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
            $move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
            $data .= ", cover_img = '$fname' ";
        }
        $chk = $this->db->query("SELECT * FROM system_settings");
        if ($chk->num_rows > 0) {
            $save = $this->db->query("UPDATE system_settings SET $data");
        } else {
            $save = $this->db->query("INSERT INTO system_settings SET $data");
        }
        if ($save) {
            $query = $this->db->query("SELECT * FROM system_settings LIMIT 1")->fetch_array();
            foreach ($query as $key => $value) {
                if (!is_numeric($key))
                    $_SESSION['system'][$key] = $value;
            }
            return 1;
        }
    }

    // Course Management Methods
    function save_course() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id', 'fid', 'type', 'amount')) && !is_numeric($k)) {
                if (empty($data)) {
                    $data .= " $k='$v' ";
                } else {
                    $data .= ", $k='$v' ";
                }
            }
        }
        $check = $this->db->query("SELECT * FROM courses WHERE course = '$course' AND level = '$level' " . (!empty($id) ? " AND id != $id " : ''))->num_rows;
        if ($check > 0) {
            return 2;
            exit;
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO courses SET $data");
            if ($save) {
                $id = $this->db->insert_id;
                foreach ($fid as $k => $v) {
                    $data = " course_id = '$id' ";
                    $data .= ", description = '{$type[$k]}' ";
                    $data .= ", amount = '{$amount[$k]}' ";
                    $save2[] = $this->db->query("INSERT INTO fees SET $data");
                }
                if (isset($save2))
                    return 1;
            }
        } else {
            $save = $this->db->query("UPDATE courses SET $data WHERE id = $id");
            if ($save) {
                $this->db->query("DELETE FROM fees WHERE course_id = $id AND id NOT IN (" . implode(',', $fid) . ")");
                foreach ($fid as $k => $v) {
                    $data = " course_id = '$id' ";
                    $data .= ", description = '{$type[$k]}' ";
                    $data .= ", amount = '{$amount[$k]}' ";
                    if (empty($v)) {
                        $save2[] = $this->db->query("INSERT INTO fees SET $data");
                    } else {
                        $save2[] = $this->db->query("UPDATE fees SET $data WHERE id = $v");
                    }
                }
                if (isset($save2))
                    return 1;
            }
        }
    }

    function delete_course() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM courses WHERE id = $id");
        $delete2 = $this->db->query("DELETE FROM fees WHERE course_id = $id");
        if ($delete && $delete2) {
            return 1;
        }
    }

    // Student Management Methods
    function save_student() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id')) && !is_numeric($k)) {
                if (empty($data)) {
                    $data .= " $k='$v' ";
                } else {
                    $data .= ", $k='$v' ";
                }
            }
        }
        $check = $this->db->query("SELECT * FROM student WHERE id_no = '$id_no' " . (!empty($id) ? " AND id != $id " : ''))->num_rows;
        if ($check > 0) {
            return 2;
            exit;
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO student SET $data");
        } else {
            $save = $this->db->query("UPDATE student SET $data WHERE id = $id");
        }
        if ($save)
            return 1;
    }

    function delete_student() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM student WHERE id = $id");
        if ($delete) {
            return 1;
        }
    }

    // Fees Management Methods
    function save_fees() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id')) && !is_numeric($k)) {
                if ($k == 'total_fee') {
                    $v = str_replace(',', '', $v);
                }
                if (empty($data)) {
                    $data .= " $k='$v' ";
                } else {
                    $data .= ", $k='$v' ";
                }
            }
        }
        $check = $this->db->query("SELECT * FROM student_ef_list WHERE ef_no = '$ef_no' " . (!empty($id) ? " AND id != $id " : ''))->num_rows;
        if ($check > 0) {
            return 2;
            exit;
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO student_ef_list SET $data");
        } else {
            $save = $this->db->query("UPDATE student_ef_list SET $data WHERE id = $id");
        }
        if ($save)
            return 1;
    }

    function delete_fees() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM student_ef_list WHERE id = $id");
        if ($delete) {
            return 1;
        }
    }

    // Payment Management Methods
    function save_payment() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id')) && !is_numeric($k)) {
                if ($k == 'amount') {
                    $v = str_replace(',', '', $v);
                }
                if (empty($data)) {
                    $data .= " $k='$v' ";
                } else {
                    $data .= ", $k='$v' ";
                }
            }
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO payments SET $data");
            if ($save)
                $id = $this->db->insert_id;
        } else {
            $save = $this->db->query("UPDATE payments SET $data WHERE id = $id");
        }
        if ($save)
            return json_encode(array('ef_id' => $ef_id, 'pid' => $id, 'status' => 1));
    }

    function delete_payment() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM payments WHERE id = $id");
        if ($delete) {
            return 1;
        }
    }

    // Teacher Management Methods
    function save_teacher() {
        extract($_POST);
        $data = " name = '$name' ";
        $data .= ", id_no = '$id_no' ";
        $data .= ", email = '$email' ";
        $data .= ", contact = '$contact' ";
        $data .= ", address = '$address' ";

        // Check if teacher with the same ID No. already exists
        $check = $this->db->query("SELECT * FROM teacher WHERE id_no = '$id_no' " . (!empty($id) ? " AND id != $id" : ""))->num_rows;
        if ($check > 0) {
            return 2; // Duplicate ID No.
        }

        if (empty($id)) {
            // Insert new teacher
            $save = $this->db->query("INSERT INTO teacher SET $data");
        } else {
            // Update existing teacher
            $save = $this->db->query("UPDATE teacher SET $data WHERE id = $id");
        }

        if ($save) {
            return 1; // Success
        } else {
            return 0; // Error
        }
    }

    function delete_teacher() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM teacher WHERE id = $id");
        if ($delete) {
            return 1; // Success
        } else {
            return 0; // Error
        }
    }
	

    
	public function save_salary() {
        extract($_POST);
        $data = " teacher_id = '$teacher_id' ";
        $data .= ", amount = '$amount' ";
        $data .= ", payment_date = '$payment_date' ";
        $data .= ", remarks = '$remarks' ";

        if (empty($id)) {
            $save = $this->db->query("INSERT INTO salary SET $data");
        } else {
            $save = $this->db->query("UPDATE salary SET $data WHERE id = $id");
        }

        if ($save) {
            return 1; // Success
        } else {
            return 0; // Error
        }
    }

    public function delete_salary() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM salary WHERE id = $id");
        if ($delete) {
            return 1; // Success
        } else {
            return 0; // Error
        }
    }
}
