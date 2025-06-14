<?php
// edit_events.php

// Include database connection
include('db.php');

// Check if a search term is provided
$search_term = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_event'])) {
    $search_term = $_POST['search_term'];
}

// Fetch events based on search term
$sql = "SELECT * FROM events";
if (!empty($search_term)) {
    $sql .= " WHERE event_name LIKE ?";
}
$stmt = $conn->prepare($sql);

if (!empty($search_term)) {
    $like_search_term = '%' . $search_term . '%';
    $stmt->bind_param("s", $like_search_term);
}

$stmt->execute();
$result = $stmt->get_result();

// Check if the form has been submitted to update event details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_event'])) {
    // Collecting data from the form
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_venue = $_POST['event_venue'];
    $ticket_price = $_POST['ticket_price'];

    // Update the event details in the database
    $update_sql = "UPDATE events SET event_name = ?, event_date = ?, event_time = ?, event_venue = ?, ticket_price = ? WHERE event_id = ?";
    $update_stmt = $conn->prepare($update_sql);

    if ($update_stmt === false) {
        die("Database prepare statement failed: " . htmlspecialchars($conn->error));
    }

    $update_stmt->bind_param("ssssdi", $event_name, $event_date, $event_time, $event_venue, $ticket_price, $event_id);

    if ($update_stmt->execute()) {
        echo "<p style='color: green;'>Event details updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to update event details: " . htmlspecialchars($update_stmt->error) . "</p>";
    }
    $update_stmt->close();
}

// Display the search form
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        /* General Styling */
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        
        h1 {
            color: #00ffcc;
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        /* Container Styling */
        .events-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* This will make it display 2 forms per row */
    gap: 20px;
}

        
        .event {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .event label {
            font-weight: bold;
            font-size: 14px;
        }

        .event input[type="text"],
        .event input[type="date"],
        .event input[type="time"],
        .event input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #444444;
            background-color: #333333;
            color: #ffffff;
            font-size: 16px;
            box-sizing: border-box;
        }

        .event button {
            padding: 12px 20px;
            background-color: #00cc66;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .event button:hover {
            background-color: #00994d;
        }

        /* Search Form */
        .search-container {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        
        .search-container input[type="text"] {
            width: 300px;
            height: 40px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #333333;
            color: #ffffff;
            font-size: 16px;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #00cc66;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-container button:hover {
            background-color: #00994d;
        }

        .suggestions {
            position: absolute;
            top: 50px;
            width: 300px;
            background-color: #333333;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            z-index: 10;
            color: #ffffff;
        }

        .suggestions li {
            padding: 10px;
            cursor: pointer;
        }

        .suggestions li:hover {
            background-color: #444444;
        }
    </style>
</head>
<body>
    <h1>Edit Your Events</h1>

    <div class="search-container">
        <form action="" method="post">
            <input type="text" id="search-bar" name="search_term" placeholder="Search by event name" value="<?php echo htmlspecialchars($search_term); ?>" autocomplete="off">
            <button type="submit" name="search_event">Search</button>
        </form>
        <ul id="suggestions" class="suggestions"></ul>
    </div>

    <?php
    // Display the list of events
    if ($result->num_rows > 0) {
        echo "<div class='events-container'>"; // Start grid container
        while ($row = $result->fetch_assoc()) {
            echo "<form action='' method='post'>"; // Separate form for each event
            echo "<div class='event'>";
            echo "<input type='hidden' name='event_id' value='" . $row['event_id'] . "'>";
            echo "<label>Event Name: <input type='text' name='event_name' value='" . htmlspecialchars($row['event_name']) . "' required></label>";
            echo "<label>Event Date: <input type='date' name='event_date' value='" . htmlspecialchars($row['event_date']) . "' required></label>";
            echo "<label>Event Time: <input type='time' name='event_time' value='" . htmlspecialchars($row['event_time']) . "' required></label>";
            echo "<label>Venue: <input type='text' name='event_venue' value='" . htmlspecialchars($row['event_venue']) . "' required></label>";
            echo "<label>Ticket Price: <input type='number' step='0.01' name='ticket_price' value='" . htmlspecialchars($row['ticket_price']) . "' required></label>";
            echo "<button type='submit' name='update_event'>Edit Event</button>";
            echo "</div>";
            echo "</form>";
        }
        echo "</div>"; // End grid container
    } else {
        echo "<p>No events found.</p>";
    }

    $stmt->close();
    ?>

    <script>
        // JavaScript for live search
        const searchBar = document.getElementById('search-bar');
        const suggestions = document.getElementById('suggestions');

        searchBar.addEventListener('input', function() {
            const searchTerm = searchBar.value;

            if (searchTerm.length > 0) {
                fetch(`search_events.php?term=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestions.innerHTML = '';
                        data.forEach(event => {
                            const li = document.createElement('li');
                            li.textContent = event;
                            li.addEventListener('click', () => {
                                searchBar.value = event;
                                suggestions.innerHTML = '';
                            });
                            suggestions.appendChild(li);
                        });
                    });
            } else {
                suggestions.innerHTML = '';
            }
        });

        document.addEventListener('click', (e) => {
            if (!searchBar.contains(e.target)) {
                suggestions.innerHTML = '';
            }
        });
    </script>
</body>
</html>
