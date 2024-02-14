<?php
declare(strict_types=1);
require_once 'core/init.php';
require_once 'service/VestService.php';
require_once 'service/RubrikaService.php';

$user = new UserManager();
$naslov = "%" . strtolower(Input::get('naslov')) . "%";
$tagovi = "%" . strtolower(Input::get('tagovi')) . "%";
$start_date = null;
if(Input::get('start_date')) {
    $start_date = Input::get('start_date');
}

$end_date = null;
if(Input::get('end_date')) {
    $end_date = Input::get('end_date');
}
$vesti_pre_rubrika = VestService::getInstance()->searchVest($naslov, $tagovi, $start_date, $end_date);
$rubrike_id = Input::get('dropdown-group');
$vesti = array();
foreach($vesti_pre_rubrika as $vest) {
    if($rubrike_id && in_array($vest->getIdRubrika(), $rubrike_id)) {
        array_push($vesti, $vest);
    } else {
        array_push($vesti, $vest);
    }
}
function sortVesti($vest1, $vest2) {
  if ($vest1->getDatum() === $vest2->getDatum()) {
      return 0;
  }
  return ($vest1->getDatum() > $vest2->getDatum()) ? -1 : 1;
}

usort($vesti, 'sortVesti');
require_once 'navbar.php';
require_once 'functions/truncate.php';
?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">
<head>
    <meta charset="UTF-8">
    <title>Cars</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <!-- Include FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .car-card {
            max-width: 18rem;
            margin-bottom: 1rem;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.2);
        }
        .car-card .card-img-top {
            height: 200px; /* Set a fixed height for the car image */
            object-fit: cover; /* Ensure the image covers the entire container */
        }
        .navbar {
            background-color: #212529;
        }

        .navbar-brand {
            color: #f8f9fa;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #f8f9fa;
        }

        .navbar-nav .nav-link:hover {
            color: #adb5bd;
        }

        .navbar-nav .active {
            font-weight: bold;
        }

        h1 {
            color: #343a40;
            font-weight: bold;
        }

        label {
            color: #343a40;
        }

        .form-control {
            border-color: #343a40;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0069d9;
        }
        body {
            background-color: #f7f7f7;
        }


        * {
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
            color: #379937;
        }

        .dropdown {
            position: relative;
            font-size: 14px;
            color: #333;
            z-index: 1000;

        .dropdown-list {
            padding: 12px;
            background: #fff;
            position: absolute;
            top: 30px;
            left: 2px;
            right: 2px;
            box-shadow: 0 1px 2px 1px rgba(0, 0, 0, .15);
            transform-origin: 50% 0;
            transform: scale(1, 0);
            transition: transform .15s ease-in-out .15s;
            max-height: 66vh;
            overflow-y: scroll;
            z-index: 100;
        }
        
        .dropdown-option {
            display: block;
            padding: 8px 12px;
            opacity: 0;
            transition: opacity .15s ease-in-out;
        }
        
        .dropdown-label {
            display: block;
            height: 30px;
            background: #fff;
            border: 1px solid #ccc;
            padding: 6px 12px;
            line-height: 1;
            cursor: pointer;
            
            &:before {
            content: '▼';
            float: right;
            }
        }
        
        &.on {
        .dropdown-list {
            transform: scale(1, 1);
            transition-delay: 0s;
            
            .dropdown-option {
                opacity: 1;
                transition-delay: .2s;
            }
            }
            
            .dropdown-label:before {
            content: '▲';
            }
        }
        
        [type="checkbox"] {
            position: relative;
            top: -1px;
            margin-right: 4px;
        }
        }
        
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="searchForm" method="get" action="">
                <div class="row text-center">
                    <h1>Search</h1>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="model">Naslov:</label>
                            <input type="text" class="form-control" id="naslov" name="naslov" value="<?php echo Input::get('naslov'); ?>" >
                        </div>
                        <div class="form-group">
                            <label for="model">Tagovi:</label>
                            <input type="text" class="form-control" id="tagovi" name="tagovi" value="<?php echo Input::get('tagovi'); ?>" >
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="startYear">Start Year:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo Input::get('start_date'); ?>" onchange="validateDates()">
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="endYear">End Year:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo Input::get('end_date'); ?>" onchange="validateDates()">
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            Rubrike:
                            <div class="dropdown" data-control="checkbox-dropdown">
                                <label class="dropdown-label">Select</label>
                                
                                <div class="dropdown-list">
                                    <a href="#" data-toggle="check-all" class="dropdown-option">
                                    Check All
                                    </a>
                                    <?php
                                        $rubrike = RubrikaService::getInstance()->getAllRubrikas();
                                        if(count($rubrike) > 0) {
                                            foreach($rubrike as $rubrika) {
                                                echo    '<label class="dropdown-option">';
                                                echo    '<input type="checkbox" name="dropdown-group[]" value="'. $rubrika->getIdRubrika() . '" />';
                                                echo    $rubrika->getIme();
                                                echo    '</label>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center my-2 justify-content-center">
                        <div class="form-group ms-2 ps-4">
                            <button type="submit" class="btn btn-dark">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row my-2"></div>
</div>
<div class="container">
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($vesti as $vest): ?>
      <?php if ($vest->getStatus() === 'ODOBRENA' || $vest->getStatus() === 'PENDING_DELETION'): ?>
        <div class="col mb-3">
          <div class="card h-100 article">
            <div class="card-body">
              <h1 class="card-title"><?php echo $vest->getNaslov(); ?></h1>
              <p class="card-text"><?php echo truncate($vest->getTekst(), 250, '...', true, true); ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <i class="fas fa-thumbs-up"></i> <?php echo $vest->getLajkovi(); ?>
                  <i class="fas fa-thumbs-down"></i> <?php echo $vest->getDislajkovi(); ?>
                </div>
                <a href="vest.php?id=<?php echo $vest->getIdVest(); ?>" class="btn btn-primary">Read More</a>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function($) {
  var CheckboxDropdown = function(el) {
    var _this = this;
    this.isOpen = false;
    this.areAllChecked = false;
    this.$el = $(el);
    this.$label = this.$el.find('.dropdown-label');
    this.$checkAll = this.$el.find('[data-toggle="check-all"]').first();
    this.$inputs = this.$el.find('[type="checkbox"]');
    
    this.onCheckBox();
    
    this.$label.on('click', function(e) {
      e.preventDefault();
      _this.toggleOpen();
    });
    
    this.$checkAll.on('click', function(e) {
      e.preventDefault();
      _this.onCheckAll();
    });
    
    this.$inputs.on('change', function(e) {
      _this.onCheckBox();
    });
  };
  
  CheckboxDropdown.prototype.onCheckBox = function() {
    this.updateStatus();
  };
  
  CheckboxDropdown.prototype.updateStatus = function() {
    var checked = this.$el.find(':checked');
    
    this.areAllChecked = false;
    this.$checkAll.html('Check All');
    
    if(checked.length <= 0) {
      this.$label.html('Select Options');
    }
    else if(checked.length === 1) {
      this.$label.html(checked.parent('label').text());
    }
    else if(checked.length === this.$inputs.length) {
      this.$label.html('All Selected');
      this.areAllChecked = true;
      this.$checkAll.html('Uncheck All');
    }
    else {
      this.$label.html(checked.length + ' Selected');
    }
  };
  
  CheckboxDropdown.prototype.onCheckAll = function(checkAll) {
    if(!this.areAllChecked || checkAll) {
      this.areAllChecked = true;
      this.$checkAll.html('Uncheck All');
      this.$inputs.prop('checked', true);
    }
    else {
      this.areAllChecked = false;
      this.$checkAll.html('Check All');
      this.$inputs.prop('checked', false);
    }
    
    this.updateStatus();
  };
  
  CheckboxDropdown.prototype.toggleOpen = function(forceOpen) {
    var _this = this;
    
    if(!this.isOpen || forceOpen) {
       this.isOpen = true;
       this.$el.addClass('on');
      $(document).on('click', function(e) {
        if(!$(e.target).closest('[data-control]').length) {
         _this.toggleOpen();
        }
      });
    }
    else {
      this.isOpen = false;
      this.$el.removeClass('on');
      $(document).off('click');
    }
  };
  
  var checkboxesDropdowns = document.querySelectorAll('[data-control="checkbox-dropdown"]');
  for(var i = 0, length = checkboxesDropdowns.length; i < length; i++) {
    new CheckboxDropdown(checkboxesDropdowns[i]);
  }
})(jQuery);
    function validateDates() {
        var startDate = document.getElementById("start_date").value;
        var endDate = document.getElementById("end_date").value;

        if (startDate && endDate) {
            if (startDate > endDate) {
                alert("End date cannot be earlier than start date!");
                document.getElementById("end_date").value = "";
            }
        }
    }
</script>
</body>
</html>
