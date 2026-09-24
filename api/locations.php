<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Comprehensive Uganda Locations Dataset (Cities, Towns, and Major Areas/Streets)
$ugandaLocations = [
    [
        "city" => "Kampala",
        "areas" => [
            "Nakawa", "Banda", "Ntinda", "Kyambogo", "Bugolobi", 
            "Kololo", "Kira Road", "Lugogo", "Kamwokya", "Bukoto", 
            "Kisementi", "Wandegeya", "Makerere", "Kavule", "Old Kampala", 
            "Central Business District (CBD)", "Nakasero", "Kigoowa", "Ntinda Complex",
            "Muyenga", "Kabalagala", "Nsambya", "Ggaba Road", "Kibuli",
            "Katikiti", "Busega", "Mengo", "Rubaga", "Namirembe", "Kawaala"
        ]
    ],
    [
        "city" => "Entebbe",
        "areas" => [
            "Kitooro", "Manyago", "Katabi", "Abayita Ababiri", "Nakiwogo", 
            "Lugard Avenue", "Kampala Road", "State House Road", "Golf Course Area"
        ]
    ],
    [
        "city" => "Jinja",
        "areas" => [
            "Main Street", "Source of the Nile", "Walukuba", "Kimaka", 
            "Mpumude", "Bugembe", "Idudi Road", "Lubaga Road"
        ]
    ],
    [
        "city" => "Wakiso",
        "areas" => [
            "Najjera", "Kira", "Namugongo", "Kasanje", "Bulindo", 
            "Kiwatule", "Gayaza Road", "Kasangati", "Matugga", "Nansana", 
            "Nabweru", "Kigungu", "Nsangi", "Kyengera", "Kajjansi", "Bwebajja"
        ]
    ],
    [
        "city" => "Mukono",
        "areas" => [
            "Seeta", "Goma", "Namilyango", "Colline", "Jinja Road", 
            "Kigunga", "Mpigi", "Kayanja Zone"
        ]
    ],
    [
        "city" => "Mbarara",
        "areas" => [
            "High Street", "Kakoba", "Nyamitanga", "Kakyeka", "Bubaare", 
            "Rwemigina", "Booma", "Kihumuro"
        ]
    ],
    [
        "city" => "Gulu",
        "areas" => [
            "Commercial Road", "Pece", "Bardege", "Layibi", "Kanyagoga", "Cereleno"
        ]
    ],
    [
        "city" => "Mbale",
        "areas" => [
            "Republic Street", "Nkokonjeru", "Industrial Area", "Senior Quarters", "Namatala"
        ]
    ]
];

// Check if a specific city was requested
$requestedCity = isset($_GET['city']) ? trim($_GET['city']) : '';

if ($requestedCity !== '') {
    // Return only areas for the requested city
    $foundAreas = [];
    foreach ($ugandaLocations as $loc) {
        if (strcasecmp($loc['city'], $requestedCity) === 0) {
            $foundAreas = $loc['areas'];
            break;
        }
    }
    echo json_encode([
        "success" => true,
        "city" => $requestedCity,
        "areas" => $foundAreas
    ]);
} else {
    // Return all cities and their areas
    echo json_encode([
        "success" => true,
        "data" => $ugandaLocations
    ]);
}
?>