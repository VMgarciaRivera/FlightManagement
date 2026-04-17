<?php
echo "Drivers PDO disponibles: " . implode(", ", PDO::getAvailableDrivers());