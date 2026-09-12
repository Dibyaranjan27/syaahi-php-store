<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Syaahi | Admin Portal </title>


    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/dashboard/">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

<!-- Syaahi Custom Fonts and Styles -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Nunito:wght@400;600;700&family=WindSong:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/syaahi.css?v=<?php echo time(); ?>">


    <link href="./css/dashboard.css" rel="stylesheet">
    <style>
      body {
        background-color: #fcf9ff; /* soft pastel background */
        font-family: 'Nunito', sans-serif;
      }
      .sidebar {
        background-color: #ffffff !important;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05) !important;
        padding-top: 20px !important;
        border-right: none !important;
      }
      @media (min-width: 768px) {
        [role="main"] {
            padding-top: 10px !important; 
        }
      }
      .sidebar .nav-link {
        border-radius: 50px;
        margin: 5px 15px;
        color: #4b5563;
        font-weight: 600;
        transition: all 0.2s;
        padding: 10px 20px;
      }
      .sidebar .nav-link:hover, .sidebar .nav-link.active {
        background-color: var(--lavender-light, #f3e8ff);
        color: var(--dark-purple, #6b21a8);
      }
      .sidebar .nav-link i {
        margin-right: 10px;
        color: var(--lavender, #c084fc);
      }
      h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
        font-family: 'Carter One', cursive;
        color: var(--dark-purple, #3b0764);
      }
      .syaahi-admin-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
      }
      .syaahi-admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
      }
      .syaahi-admin-card .card-body i {
        font-size: 2.5rem;
        opacity: 0.8;
      }
      
      .fa-trash-alt,.fa-pencil-alt{
        color: #fff;
      }
      .table-pastel {
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
      }
      .table-pastel thead th {
        background-color: var(--lavender-light, #f3e8ff);
        color: var(--dark-purple, #6b21a8);
        border: none;
        padding: 15px;
      }
      .table-pastel tbody td {
        vertical-align: middle;
        padding: 15px;
        color: #4b5563;
        border-bottom: 1px solid #f3f4f6;
      }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>

 <body>