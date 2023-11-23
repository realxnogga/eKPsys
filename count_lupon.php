<?php 

$linkedNamesQuery = "SELECT 
                        COUNT(NULLIF(name1, '')) + 
                        COUNT(NULLIF(name2, '')) + 
                        COUNT(NULLIF(name3, '')) + 
                        COUNT(NULLIF(name4, '')) + 
                        COUNT(NULLIF(name5, '')) + 
                        COUNT(NULLIF(name6, '')) + 
                        COUNT(NULLIF(name7, '')) + 
                        COUNT(NULLIF(name8, '')) + 
                        COUNT(NULLIF(name9, '')) + 
                        COUNT(NULLIF(name10, '')) + 
                        COUNT(NULLIF(name11, '')) + 
                        COUNT(NULLIF(name12, '')) + 
                        COUNT(NULLIF(name13, '')) + 
                        COUNT(NULLIF(name14, '')) + 
                        COUNT(NULLIF(name15, '')) + 
                        COUNT(NULLIF(name16, '')) + 
                        COUNT(NULLIF(name17, '')) + 
                        COUNT(NULLIF(name18, '')) + 
                        COUNT(NULLIF(name19, '')) + 
                        COUNT(NULLIF(name20, '')) AS count_values
                    FROM lupons
                    WHERE user_id = :user_id";

$linkedNamesStmt = $conn->prepare($linkedNamesQuery);
$linkedNamesStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$linkedNamesStmt->execute();
$countValues = $linkedNamesStmt->fetchColumn();

// Store the count in a session variable
$_SESSION['linkedNamesCount'] = $countValues;


 ?>