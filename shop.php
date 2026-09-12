<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Supplements & Gym Gear</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        body {
            background-color: #ffffff;
            color: #222222;
            padding: 20px;
        }
        .container {
            max-width: 1350px;
            margin: 0 auto;
        }
        .flash-sale-wrapper {
            background-color: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 20px;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .title-area {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .title-area h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111;
        }
        .flash-icon {
            color: #f68b1e;
            font-size: 1.2rem;
        }
        .timer-badge {
            background-color: #fef2f2;
            color: #e02424;
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 600;
        }
        .see-all {
            color: #f68b1e;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .see-all:hover {
            text-decoration: underline;
        }

        /* Grid layout for 4 items per row */
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }
        @media (max-width: 1024px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            padding: 10px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: box-shadow 0.2s ease;
            margin-bottom: 12px;
        }
        .card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #e02424;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 2px;
            z-index: 2;
        }
        .card img {
            width: 100%;
            height: 140px;
            object-fit: contain;
            margin-bottom: 8px;
            background-color: #fff;
        }
        .card h3 {
            font-size: 0.85rem;
            font-weight: 400;
            color: #333333;
            margin-bottom: 8px;
            line-height: 1.25;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.5em;
        }
        .price-box {
            margin-bottom: 6px;
        }
        .current-price {
            font-size: 1rem;
            font-weight: 700;
            color: #111111;
        }
        .old-price {
            font-size: 0.75rem;
            color: #888888;
            text-decoration: line-through;
            margin-left: 4px;
        }
        
        /* Progress bar styling */
        .progress-container {
            margin-top: 4px;
        }
        .progress-bar-bg {
            width: 100%;
            height: 6px;
            background-color: #f0f0f0;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 3px;
        }
        .progress-bar-fill {
            height: 100%;
            background-color: #f68b1e;
            border-radius: 3px;
        }
        .sold-text {
            font-size: 0.7rem;
            color: #757575;
        }
    </style>
</head>



<body>


<?php include 'includes/header.php'; ?>


    <div class="container">
        <div class="flash-sale-wrapper">
            <div class="header-row">
                <div class="title-area">
                  
                    <h2>Special Offers</h2>
                </div>
         
                <a href="#" class="see-all">See All &gt;</a>
            </div>

            <div class="grid">
                <?php
                $products = [
                    ["name" => "Whey Protein Isolate, Chocolate, 2kg", "price" => "UGX 185,000", "old_price" => "240,000", "discount" => "-23%", "sold" => "75% sold", "percent" => "75%", "image" => "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Micronised Creatine Monohydrate, 300g", "price" => "UGX 65,000", "old_price" => "90,000", "discount" => "-28%", "sold" => "45% sold", "percent" => "45%", "image" => "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Explosive Pre-Workout Booster, 400g", "price" => "UGX 85,000", "old_price" => "100,000", "discount" => "-15%", "sold" => "90% sold", "percent" => "90%", "image" => "https://images.unsplash.com/photo-1579722821273-0f6c7c44369f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Super Mass Gainer, Vanilla, 3kg", "price" => "UGX 210,000", "old_price" => "260,000", "discount" => "-20%", "sold" => "60% sold", "percent" => "60%", "image" => "https://images.unsplash.com/photo-1579722820308-d74e57190009?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Leak-Proof Protein Shaker Bottle, 700ml", "price" => "UGX 15,000", "old_price" => "22,000", "discount" => "-30%", "sold" => "30% sold", "percent" => "30%", "image" => "https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Adjustable Dumbbells Set, Pair", "price" => "UGX 750,000", "old_price" => "850,000", "discount" => "-12%", "sold" => "80% sold", "percent" => "80%", "image" => "https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Heavy Duty Resistance Exercise Bands", "price" => "UGX 90,000", "old_price" => "120,000", "discount" => "-25%", "sold" => "50% sold", "percent" => "50%", "image" => "https://images.unsplash.com/photo-1598289431512-b97b09177c42?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Ergonomic Professional Lifting Belt", "price" => "UGX 170,000", "old_price" => "210,000", "discount" => "-19%", "sold" => "20% sold", "percent" => "20%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "BCAA Amino Acids Recovery Formula", "price" => "UGX 115,000", "old_price" => "145,000", "discount" => "-21%", "sold" => "65% sold", "percent" => "65%", "image" => "https://images.unsplash.com/photo-1550572017-edd951b55104?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Olympic Barbell Steel Bar", "price" => "UGX 520,000", "old_price" => "600,000", "discount" => "-13%", "sold" => "40% sold", "percent" => "40%", "image" => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Cast Iron Kettlebell 16kg", "price" => "UGX 230,000", "old_price" => "280,000", "discount" => "-18%", "sold" => "85% sold", "percent" => "85%", "image" => "https://images.unsplash.com/photo-1566241142559-40e1dab266c6?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Ab Roller Exercise Wheel", "price" => "UGX 45,000", "old_price" => "60,000", "discount" => "-25%", "sold" => "70% sold", "percent" => "70%", "image" => "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "L-Glutamine Muscle Recovery", "price" => "UGX 95,000", "old_price" => "120,000", "discount" => "-20%", "sold" => "55% sold", "percent" => "55%", "image" => "https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Doorway Pull-Up Bar", "price" => "UGX 85,000", "old_price" => "110,000", "discount" => "-22%", "sold" => "48% sold", "percent" => "48%", "image" => "https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Omega-3 Fish Oil Softgels", "price" => "UGX 60,000", "old_price" => "80,000", "discount" => "-25%", "sold" => "92% sold", "percent" => "92%", "image" => "https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Gym Chalk Block for Grip", "price" => "UGX 20,000", "old_price" => "30,000", "discount" => "-33%", "sold" => "78% sold", "percent" => "78%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    
                    // 50 Additional Items
                    ["name" => "Hydrolyzed Whey Protein 5lbs", "price" => "UGX 295,000", "old_price" => "350,000", "discount" => "-15%", "sold" => "60% sold", "percent" => "60%", "image" => "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Plant-Based Vegan Protein Powder", "price" => "UGX 190,000", "old_price" => "230,000", "discount" => "-17%", "sold" => "40% sold", "percent" => "40%", "image" => "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Extreme Nitric Oxide Booster", "price" => "UGX 110,000", "old_price" => "140,000", "discount" => "-21%", "sold" => "72% sold", "percent" => "72%", "image" => "https://images.unsplash.com/photo-1579722821273-0f6c7c44369f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Casein Slow-Release Protein", "price" => "UGX 215,000", "old_price" => "260,000", "discount" => "-17%", "sold" => "35% sold", "percent" => "35%", "image" => "https://images.unsplash.com/photo-1579722820308-d74e57190009?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "EAA Essential Amino Acids", "price" => "UGX 125,000", "old_price" => "160,000", "discount" => "-21%", "sold" => "58% sold", "percent" => "58%", "image" => "https://images.unsplash.com/photo-1550572017-edd951b55104?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Fat Burner Thermogenic Capsules", "price" => "UGX 105,000", "old_price" => "135,000", "discount" => "-22%", "sold" => "82% sold", "percent" => "82%", "image" => "https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "ZMA Nighttime Recovery Formula", "price" => "UGX 75,000", "old_price" => "95,000", "discount" => "-21%", "sold" => "44% sold", "percent" => "44%", "image" => "https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Testosterone Booster Complex", "price" => "UGX 160,000", "old_price" => "200,000", "discount" => "-20%", "sold" => "67% sold", "percent" => "67%", "image" => "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Joint Support Glucosamine Chondroitin", "price" => "UGX 85,000", "old_price" => "110,000", "discount" => "-22%", "sold" => "53% sold", "percent" => "53%", "image" => "https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "High-Potency Multivitamin", "price" => "UGX 70,000", "old_price" => "90,000", "discount" => "-22%", "sold" => "90% sold", "percent" => "90%", "image" => "https://images.unsplash.com/photo-1550572017-edd951b55104?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Liquid L-Carnitine 3000mg", "price" => "UGX 95,000", "old_price" => "120,000", "discount" => "-20%", "sold" => "61% sold", "percent" => "61%", "image" => "https://images.unsplash.com/photo-1579722821273-0f6c7c44369f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Dextrose Fast Carbs Powder", "price" => "UGX 40,000", "old_price" => "55,000", "discount" => "-27%", "sold" => "39% sold", "percent" => "39%", "image" => "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "HMB Muscle Protector", "price" => "UGX 115,000", "old_price" => "150,000", "discount" => "-23%", "sold" => "31% sold", "percent" => "31%", "image" => "https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Citrulline Malate Powder", "price" => "UGX 90,000", "old_price" => "115,000", "discount" => "-21%", "sold" => "55% sold", "percent" => "55%", "image" => "https://images.unsplash.com/photo-1579722820308-d74e57190009?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Beta-Alanine Endurance Powder", "price" => "UGX 80,000", "old_price" => "100,000", "discount" => "-20%", "sold" => "49% sold", "percent" => "49%", "image" => "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Mass Gainer Extreme 5kg", "price" => "UGX 320,000", "old_price" => "390,000", "discount" => "-17%", "sold" => "78% sold", "percent" => "78%", "image" => "https://images.unsplash.com/photo-1579722820308-d74e57190009?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Micellar Casein Chocolate", "price" => "UGX 220,000", "old_price" => "270,000", "discount" => "-18%", "sold" => "41% sold", "percent" => "41%", "image" => "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Organic Peanut Butter for Athletes", "price" => "UGX 35,000", "old_price" => "45,000", "discount" => "-22%", "sold" => "95% sold", "percent" => "95%", "image" => "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Protein Bar Box (12 Pack)", "price" => "UGX 90,000", "old_price" => "115,000", "discount" => "-21%", "sold" => "88% sold", "percent" => "88%", "image" => "https://images.unsplash.com/photo-1579722821273-0f6c7c44369f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Meal Replacement Powder", "price" => "UGX 175,000", "old_price" => "210,000", "discount" => "-16%", "sold" => "52% sold", "percent" => "52%", "image" => "https://images.unsplash.com/photo-1579722820308-d74e57190009?w=500&auto=format&fit=crop&q=60"],
                    
                    // Gym Tools & Gear Extra
                    ["name" => "Fixed Rubber Hex Dumbbell 10kg", "price" => "UGX 180,000", "old_price" => "220,000", "discount" => "-18%", "sold" => "77% sold", "percent" => "77%", "image" => "https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Neoprene Kettlebell 8kg", "price" => "UGX 140,000", "old_price" => "175,000", "discount" => "-20%", "sold" => "63% sold", "percent" => "63%", "image" => "https://images.unsplash.com/photo-1566241142559-40e1dab266c6?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Olympic Weight Plates Set 50kg", "price" => "UGX 650,000", "old_price" => "750,000", "discount" => "-13%", "sold" => "50% sold", "percent" => "50%", "image" => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Heavy Duty Power Rack Cage", "price" => "UGX 2,200,000", "old_price" => "2,600,000", "discount" => "-15%", "sold" => "25% sold", "percent" => "25%", "image" => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Adjustable Flat to Incline Bench", "price" => "UGX 700,000", "old_price" => "850,000", "discount" => "-17%", "sold" => "45% sold", "percent" => "45%", "image" => "https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Speed Skipping Jump Rope", "price" => "UGX 25,000", "old_price" => "35,000", "discount" => "-28%", "sold" => "91% sold", "percent" => "91%", "image" => "https://images.unsplash.com/photo-1598289431512-b97b09177c42?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Slam Ball 10kg for Crossfit", "price" => "UGX 160,000", "old_price" => "200,000", "discount" => "-20%", "sold" => "68% sold", "percent" => "68%", "image" => "https://images.unsplash.com/photo-1566241142559-40e1dab266c6?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Gym Workout Wrist Wraps (Pair)", "price" => "UGX 35,000", "old_price" => "50,000", "discount" => "-30%", "sold" => "84% sold", "percent" => "84%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Padded Lifting Straps for Deadlifts", "price" => "UGX 30,000", "old_price" => "45,000", "discount" => "-33%", "sold" => "79% sold", "percent" => "79%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Gym Fitness Backpack with Compartments", "price" => "UGX 150,000", "old_price" => "190,000", "discount" => "-21%", "sold" => "73% sold", "percent" => "73%", "image" => "https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Push-Up Bars Stands (Pair)", "price" => "UGX 45,000", "old_price" => "60,000", "discount" => "-25%", "sold" => "66% sold", "percent" => "66%", "image" => "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Core Sliding Discs (Pair)", "price" => "UGX 25,000", "old_price" => "40,000", "discount" => "-37%", "sold" => "54% sold", "percent" => "54%", "image" => "https://images.unsplash.com/photo-1598289431512-b97b09177c42?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Gym Knee Sleeves 7mm (Pair)", "price" => "UGX 110,000", "old_price" => "140,000", "discount" => "-21%", "sold" => "71% sold", "percent" => "71%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Parallel Dip Bars Station", "price" => "UGX 280,000", "old_price" => "340,000", "discount" => "-17%", "sold" => "42% sold", "percent" => "42%", "image" => "https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Agility Ladder for Speed Training", "price" => "UGX 55,000", "old_price" => "75,000", "discount" => "-26%", "sold" => "50% sold", "percent" => "50%", "image" => "https://images.unsplash.com/photo-1598289431512-b97b09177c42?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Boxing Punching Bag Filled 4ft", "price" => "UGX 350,000", "old_price" => "430,000", "discount" => "-18%", "sold" => "39% sold", "percent" => "39%", "image" => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Boxing Training Gloves 12oz", "price" => "UGX 140,000", "old_price" => "180,000", "discount" => "-22%", "sold" => "65% sold", "percent" => "65%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Exercise Yoga Mat 10mm Thick", "price" => "UGX 75,000", "old_price" => "100,000", "discount" => "-25%", "sold" => "88% sold", "percent" => "88%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Foam Roller for Muscle Massage", "price" => "UGX 65,000", "old_price" => "85,000", "discount" => "-23%", "sold" => "76% sold", "percent" => "76%", "image" => "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Battle Rope 12M Heavy Duty", "price" => "UGX 290,000", "old_price" => "360,000", "discount" => "-19%", "sold" => "48% sold", "percent" => "48%", "image" => "https://images.unsplash.com/photo-1598289431512-b97b09177c42?w=500&auto=format&fit=crop&q=60"],

                    // More Mixed Supplements & Gear to total 66+ items
                    ["name" => "Whey Protein Isolate 10lbs Bulk", "price" => "UGX 540,000", "old_price" => "650,000", "discount" => "-16%", "sold" => "33% sold", "percent" => "33%", "image" => "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Creatine HCL Powder 200g", "price" => "UGX 75,000", "old_price" => "95,000", "discount" => "-21%", "sold" => "69% sold", "percent" => "69%", "image" => "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Insane Stimulant Pre-Workout", "price" => "UGX 130,000", "old_price" => "165,000", "discount" => "-21%", "sold" => "81% sold", "percent" => "81%", "image" => "https://images.unsplash.com/photo-1579722821273-0f6c7c44369f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Collagen Peptides Powder for Joints", "price" => "UGX 145,000", "old_price" => "180,000", "discount" => "-19%", "sold" => "57% sold", "percent" => "57%", "image" => "https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Electrolyte Hydration Powder", "price" => "UGX 65,000", "old_price" => "85,000", "discount" => "-23%", "sold" => "83% sold", "percent" => "83%", "image" => "https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Stainless Steel Shaker Bottle", "price" => "UGX 45,000", "old_price" => "60,000", "discount" => "-25%", "sold" => "89% sold", "percent" => "89%", "image" => "https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Ankle Straps for Cable Machines", "price" => "UGX 35,000", "old_price" => "50,000", "discount" => "-30%", "sold" => "64% sold", "percent" => "64%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Weighted Vest 10kg for Running", "price" => "UGX 250,000", "old_price" => "310,000", "discount" => "-19%", "sold" => "46% sold", "percent" => "46%", "image" => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Tricep Rope Attachment for Cable", "price" => "UGX 55,000", "old_price" => "75,000", "discount" => "-26%", "sold" => "72% sold", "percent" => "72%", "image" => "https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Landmine Attachment for Barbell", "price" => "UGX 120,000", "old_price" => "150,000", "discount" => "-20%", "sold" => "38% sold", "percent" => "38%", "image" => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "V-Bar Row Handle for Cable", "price" => "UGX 95,000", "old_price" => "120,000", "discount" => "-20%", "sold" => "51% sold", "percent" => "51%", "image" => "https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Lat Pulldown Bar Attachment", "price" => "UGX 130,000", "old_price" => "160,000", "discount" => "-18%", "sold" => "43% sold", "percent" => "43%", "image" => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Gym Head Harness for Neck Training", "price" => "UGX 60,000", "old_price" => "80,000", "discount" => "-25%", "sold" => "35% sold", "percent" => "35%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Dipping Belt with Heavy Chain", "price" => "UGX 95,000", "old_price" => "130,000", "discount" => "-26%", "sold" => "60% sold", "percent" => "60%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Grip Strengthener Hand Exerciser", "price" => "UGX 25,000", "old_price" => "35,000", "discount" => "-28%", "sold" => "94% sold", "percent" => "94%", "image" => "https://images.unsplash.com/photo-1598289431512-b97b09177c42?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Resistance Tube Set with Door Anchor", "price" => "UGX 75,000", "old_price" => "100,000", "discount" => "-25%", "sold" => "77% sold", "percent" => "77%", "image" => "https://images.unsplash.com/photo-1598289431512-b97b09177c42?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Plyometric Jump Box 3-in-1 Wood", "price" => "UGX 380,000", "old_price" => "460,000", "discount" => "-17%", "sold" => "29% sold", "percent" => "29%", "image" => "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Aerobic Step Platform Adjustable", "price" => "UGX 140,000", "old_price" => "180,000", "discount" => "-22%", "sold" => "53% sold", "percent" => "53%", "image" => "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Full Body Massage Gun Pro", "price" => "UGX 280,000", "old_price" => "350,000", "discount" => "-20%", "sold" => "92% sold", "percent" => "92%", "image" => "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&auto=format&fit=crop&q=60"],
                    ["name" => "Posture Corrector Brace Support", "price" => "UGX 45,000", "old_price" => "70,000", "discount" => "-35%", "sold" => "85% sold", "percent" => "85%", "image" => "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=500&auto=format&fit=crop&q=60"]
                ];

                foreach ($products as $p) {
                    echo '
                    <div class="card">
                        <div class="discount-badge">' . $p["discount"] . '</div>
                        <img src="' . $p["image"] . '" alt="' . $p["name"] . '">
                        <div>
                            <h3>' . $p["name"] . '</h3>
                            <div class="price-box">
                                <span class="current-price">' . $p["price"] . '</span>
                                <span class="old-price">' . $p["old_price"] . '</span>
                            </div>
                            <div class="progress-container">
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" style="width: ' . $p["percent"] . ';"></div>
                                </div>
                                <div class="sold-text">' . $p["sold"] . '</div>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>

</body>
</html>