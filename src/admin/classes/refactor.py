import os
import re

for file in os.listdir("."):
    if not file.endswith(".php") or file in ['Database.php', 'refactor.php', 'Admin.php']:
        continue
    
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. SELECT query without variables
    content = re.sub(
        r'\$query = \$this->con->query\("SELECT (.*?) FROM (.*?) WHERE 1"\);',
        r'$stmt = $this->con->prepare("SELECT \1 FROM \2 WHERE 1");\n\t\t$stmt->execute();\n\t\t$query = $stmt->get_result();',
        content
    )
    
    # 1b. SELECT query without variables, with some other string
    content = re.sub(
        r'\$query = \$this->con->query\("SELECT (.*?) FROM (.*?) WHERE 1 (.*?)"\);',
        r'$stmt = $this->con->prepare("SELECT \1 FROM \2 WHERE 1 \3");\n\t\t$stmt->execute();\n\t\t$query = $stmt->get_result();',
        content
    )

    # 1c. profile.php specific
    content = re.sub(
        r'\$query = \$this->con->query\("SELECT (.*?) WHERE 1 AND admin\.name=\'\$name\'"\);',
        r'$stmt = $this->con->prepare("SELECT \1 WHERE 1 AND admin.name=?");\n\t\t$stmt->bind_param("s", $name);\n\t\t$stmt->execute();\n\t\t$query = $stmt->get_result();',
        content
    )

    # 2. DELETE FROM advertisments WHERE AdsID = '$AdvertismentID'
    content = re.sub(
        r'\$q = \$this->con->query\("DELETE FROM (.*?) WHERE (.*?) = \'\$(.*?)\'"\);',
        r'$q_stmt = $this->con->prepare("DELETE FROM \1 WHERE \2 = ?");\n\t\t\t$q_stmt->bind_param("s", $\3);\n\t\t\t$q = $q_stmt->execute();',
        content
    )
    
    # 3. UPDATE advertisments SET status = 0 WHERE AdsID = '$AdvertismentID'
    content = re.sub(
        r'\$q = \$this->con->query\("UPDATE (.*?) SET (.*?) WHERE (.*?) = \'\$(.*?)\'"\);',
        r'$q_stmt = $this->con->prepare("UPDATE \1 SET \2 WHERE \3 = ?");\n\t\t\t$q_stmt->bind_param("s", $\4);\n\t\t\t$q = $q_stmt->execute();',
        content
    )

    # 4. SELECT email FROM admin WHERE email = '$email'
    content = re.sub(
        r'\$q = \$this->con->query\("SELECT (.*?) FROM (.*?) WHERE (.*?) = \'\$(.*?)\'"\);',
        r'$q_stmt = $this->con->prepare("SELECT \1 FROM \2 WHERE \3 = ?");\n\t\t$q_stmt->bind_param("s", $\4);\n\t\t$q_stmt->execute();\n\t\t$q = $q_stmt->get_result();',
        content
    )

    # 5. SELECT * FROM admin WHERE email = '$email' LIMIT 1
    content = re.sub(
        r'\$q = \$this->con->query\("SELECT (.*?) FROM (.*?) WHERE (.*?) = \'\$(.*?)\' LIMIT 1"\);',
        r'$q_stmt = $this->con->prepare("SELECT \1 FROM \2 WHERE \3 = ? LIMIT 1");\n\t\t$q_stmt->bind_param("s", $\4);\n\t\t$q_stmt->execute();\n\t\t$q = $q_stmt->get_result();',
        content
    )

    # 6. UPDATE categories SET CategoryName = '$CategoryName' WHERE CategoryID = '$CategoryID'
    content = re.sub(
        r'\$q = \$this->con->query\("UPDATE categories SET CategoryName = \'\$CategoryName\' WHERE CategoryID = \'\$CategoryID\'"\);',
        r'$q_stmt = $this->con->prepare("UPDATE categories SET CategoryName = ? WHERE CategoryID = ?");\n\t\t\t$q_stmt->bind_param("ss", $CategoryName, $CategoryID);\n\t\t\t$q = $q_stmt->execute();',
        content
    )

    # 7. DELETE FROM report WHERE report.UserID = '$UserID' AND report.AdsID = '$AdsID'
    content = re.sub(
        r'\$q = \$this->con->query\("DELETE FROM report WHERE report\.UserID = \'\$UserID\' AND report\.AdsID = \'\$AdsID\'"\);',
        r'$q_stmt = $this->con->prepare("DELETE FROM report WHERE report.UserID = ? AND report.AdsID = ?");\n\t\t\t$q_stmt->bind_param("ss", $UserID, $AdsID);\n\t\t\t$q = $q_stmt->execute();',
        content
    )

    # 8. INSERT INTO categories (CategoryName) VALUES ('$name')
    content = re.sub(
        r'\$q = \$this->con->query\("INSERT INTO categories \(CategoryName\) VALUES \(\'\$name\'\)"\);',
        r'$q_stmt = $this->con->prepare("INSERT INTO categories (CategoryName) VALUES (?)");\n\t\t\t$q_stmt->bind_param("s", $name);\n\t\t\t$q = $q_stmt->execute();',
        content
    )

    # 9. INSERT INTO `admin`(`name`, `email`, `password`) VALUES ('$name','$email','$password')
    content = re.sub(
        r'\$q = \$this->con->query\("INSERT INTO `admin`\(`name`, `email`, `password`\) VALUES \(\'\$name\',\'\$email\',\'\$password\'\)"\);',
        r'$q_stmt = $this->con->prepare("INSERT INTO `admin`(`name`, `email`, `password`) VALUES (?, ?, ?)");\n\t\t\t$q_stmt->bind_param("sss", $name, $email, $password);\n\t\t\t$q = $q_stmt->execute();',
        content
    )

    # 10. UPDATE admin SET name = '$name',email='$email',password='$password' WHERE id = '$id'
    content = re.sub(
        r'\$q = \$this->con->query\("UPDATE admin SET name = \'\$name\',email=\'\$email\',password=\'\$password\' WHERE id = \'\$id\'"\);',
        r'$q_stmt = $this->con->prepare("UPDATE admin SET name = ?, email = ?, password = ? WHERE id = ?");\n\t\t\t$q_stmt->bind_param("ssss", $name, $email, $password, $id);\n\t\t\t$q = $q_stmt->execute();',
        content
    )
    
    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
