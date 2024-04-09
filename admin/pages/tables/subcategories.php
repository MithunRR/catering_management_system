<!-- PHP code to fetch subcategories -->
<?php
include __DIR__ . '/../../../connection.php'; 

function fetchSubcategories() {
    global $conn;

    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $selectedCategory = $_GET['category'];

        $sql = "SELECT id, subcategory FROM category WHERE category = '$selectedCategory'";
        $result = $conn->query($sql);
        $subcategories_html = '';
        echo '<option value="">Select Sub Category</option>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $subcategories_html .= '<option value="' . $row['subcategory'] . '">' . $row['subcategory'] . '</option>';
            }
        } else {
            $subcategories_html = '<option value="">No subcategories found</option>';
        }

        echo $subcategories_html;
    }
    $conn->close();
}

// Use different class selectors for the jQuery script
if (isset($_GET['category'])) {
    fetchSubcategories();
}
?>
