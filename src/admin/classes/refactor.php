<?php
$files = glob("*.php");
foreach ($files as $file) {
    if ($file == 'Database.php' || $file == 'refactor.php') continue;
    $content = file_get_contents($file);
    
    // Replace SELECT queries without variables
    $content = preg_replace('/\$query = \$this->con->query\("SELECT (.*?) FROM (.*?) WHERE 1"\);/', '$query = $this->con->prepare("SELECT $1 FROM $2 WHERE 1");
		$query->execute();
		$result = $query->get_result();', $content);
        
    $content = preg_replace('/\$query = \$this->con->query\("SELECT (.*?) FROM (.*?) WHERE 1 (.*?)"\);/', '$query = $this->con->prepare("SELECT $1 FROM $2 WHERE 1 $3");
		$query->execute();
		$result = $query->get_result();', $content);
        
    // Specifically handle the profile one
    $content = preg_replace('/\$query = \$this->con->query\("SELECT (.*?) WHERE 1 AND admin.name=\'\$name\'"\);/', '$query = $this->con->prepare("SELECT $1 WHERE 1 AND admin.name=?");
		$query->bind_param("s", $name);
		$query->execute();
		$result = $query->get_result();', $content);
        
    // Replace query->num_rows with result->num_rows
    $content = str_replace('$query->num_rows', '$result->num_rows', $content);
    $content = str_replace('$query->fetch_assoc()', '$result->fetch_assoc()', $content);
    
    // Replace DELETE/UPDATE/INSERT with prepared statements using regex
    
    // 1. DELETE FROM advertisments WHERE AdsID = '$AdvertismentID'
    $content = preg_replace_callback('/\$q = \$this->con->query\("DELETE FROM (.*?) WHERE (.*?) = \'\$(.*?)\'"\);/', function($m) {
        return '$q = $this->con->prepare("DELETE FROM ' . $m[1] . ' WHERE ' . $m[2] . ' = ?");
			$q->bind_param("s", $' . $m[3] . ');
			$q->execute()';
    }, $content);
    
    // 2. UPDATE advertisments SET status = 0 WHERE AdsID = '$AdvertismentID'
    $content = preg_replace_callback('/\$q = \$this->con->query\("UPDATE (.*?) SET (.*?) WHERE (.*?) = \'\$(.*?)\'"\);/', function($m) {
        return '$q = $this->con->prepare("UPDATE ' . $m[1] . ' SET ' . $m[2] . ' WHERE ' . $m[3] . ' = ?");
			$q->bind_param("s", $' . $m[4] . ');
			$q->execute()';
    }, $content);
    
    // 3. SELECT email FROM admin WHERE email = '$email'
    $content = preg_replace_callback('/\$q = \$this->con->query\("SELECT (.*?) FROM (.*?) WHERE (.*?) = \'\$(.*?)\'"\);/', function($m) {
        return '$q = $this->con->prepare("SELECT ' . $m[1] . ' FROM ' . $m[2] . ' WHERE ' . $m[3] . ' = ?");
		$q->bind_param("s", $' . $m[4] . ');
		$q->execute();
		$result_q = $q->get_result();';
    }, $content);
    $content = preg_replace('/\$q->num_rows/', '$result_q->num_rows', $content);
    $content = preg_replace('/\$q->fetch_assoc()/', '$result_q->fetch_assoc()', $content);
    
    // 4. SELECT * FROM admin WHERE email = '$email' LIMIT 1
    $content = preg_replace_callback('/\$q = \$this->con->query\("SELECT (.*?) FROM (.*?) WHERE (.*?) = \'\$(.*?)\' LIMIT 1"\);/', function($m) {
        return '$q = $this->con->prepare("SELECT ' . $m[1] . ' FROM ' . $m[2] . ' WHERE ' . $m[3] . ' = ? LIMIT 1");
		$q->bind_param("s", $' . $m[4] . ');
		$q->execute();
		$result_q = $q->get_result();';
    }, $content);
    
    // 5. UPDATE categories SET CategoryName = '$CategoryName' WHERE CategoryID = '$CategoryID'
    $content = preg_replace_callback('/\$q = \$this->con->query\("UPDATE categories SET CategoryName = \'\$CategoryName\' WHERE CategoryID = \'\$CategoryID\'"\);/', function($m) {
        return '$q = $this->con->prepare("UPDATE categories SET CategoryName = ? WHERE CategoryID = ?");
			$q->bind_param("ss", $CategoryName, $CategoryID);
			$q->execute()';
    }, $content);
    
    // 6. DELETE FROM report WHERE report.UserID = '$UserID' AND report.AdsID = '$AdsID'
    $content = preg_replace_callback('/\$q = \$this->con->query\("DELETE FROM report WHERE report\.UserID = \'\$UserID\' AND report\.AdsID = \'\$AdsID\'"\);/', function($m) {
        return '$q = $this->con->prepare("DELETE FROM report WHERE report.UserID = ? AND report.AdsID = ?");
			$q->bind_param("ss", $UserID, $AdsID);
			$q->execute()';
    }, $content);
    
    // 7. INSERT INTO categories (CategoryName) VALUES ('$name')
    $content = preg_replace_callback('/\$q = \$this->con->query\("INSERT INTO categories \(CategoryName\) VALUES \(\'\$name\'\)"\);/', function($m) {
        return '$q = $this->con->prepare("INSERT INTO categories (CategoryName) VALUES (?)");
			$q->bind_param("s", $name);
			$q->execute()';
    }, $content);
    
    // 8. INSERT INTO `admin`(`name`, `email`, `password`) VALUES ('$name','$email','$password')
    $content = preg_replace_callback('/\$q = \$this->con->query\("INSERT INTO `admin`\(`name`, `email`, `password`\) VALUES \(\'\$name\',\'\$email\',\'\$password\'\)"\);/', function($m) {
        return '$q = $this->con->prepare("INSERT INTO `admin`(`name`, `email`, `password`) VALUES (?, ?, ?)");
			$q->bind_param("sss", $name, $email, $password);
			$q->execute()';
    }, $content);
    
    // 9. UPDATE admin SET name = '$name',email='$email',password='$password' WHERE id = '$id'
    $content = preg_replace_callback('/\$q = \$this->con->query\("UPDATE admin SET name = \'\$name\',email=\'\$email\',password=\'\$password\' WHERE id = \'\$id\'"\);/', function($m) {
        return '$q = $this->con->prepare("UPDATE admin SET name = ?, email = ?, password = ? WHERE id = ?");
			$q->bind_param("ssss", $name, $email, $password, $id);
			$q->execute()';
    }, $content);

    // Any manual query replacing where if ($q) is used because $q->execute() returns true
    // the variable $q will be boolean. The if ($q) still works.
    
    file_put_contents($file, $content);
    echo "Refactored $file\n";
}
?>
