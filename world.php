<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
$lookup  = filter_input(INPUT_GET, 'lookup', FILTER_SANITIZE_STRING);

if ($lookup === 'cities') {
    // Lookup cities
    $sql = "SELECT cities.name AS city, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table>
        <thead>
            <tr>
                <th>City</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['city']) ?></td>
                    <td><?= htmlspecialchars($row['district']) ?></td>
                    <td><?= htmlspecialchars($row['population']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
} else {

    // Lookup countries for Exercise 4
    if (!$country) {
        $stmt = $conn->query("SELECT name, continent, independence_year, head_of_state FROM countries");
    } else {
        $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state 
                                FROM countries 
                                WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table>
        <thead>
            <tr>
                <th>Country Name</th>
                <th>Continent</th>
                <th>Independence Year</th>
                <th>Head of State</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['continent']) ?></td>
                    <td><?= htmlspecialchars($row['independence_year'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($row['head_of_state']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
}
?>
