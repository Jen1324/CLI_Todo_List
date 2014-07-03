<?php

// Create array to hold list of todo items
$items = array();

// List array items formatted for CLI
function list_items($list) 
{

    $result = '';

    foreach ($list as $key => $value)
    {

        $result .= '[' . ($key + 1) . ']' . $value . PHP_EOL;
    }
        return $result;
}

// echo list_items($items);


// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true
function get_input($upper = FALSE) 
{

    $result = trim(fgets(STDIN));
    return $upper ? strtoupper($result) : $result;
}


 function sort_menu($list){
      echo '(A) - Z, (Z) - A, (O)rder entered, (R)everse order entered : ';
      $input = get_input(TRUE);

      // switch(get_input(true)) {
      //   case 'A':
      //       asort($list);
      //       break;
      //   case 'Z':
      //       arsort($list);
      //       break;
      //   case 'O':
      //       ksort($list);
      //       break;
      //   case 'R':
      //       krsort($list);
      //       break;
      // }


        if ($input == 'A') 
        {
            asort($list);
        }
        elseif ($input == 'Z') 
        {
            arsort($list);
        }
        elseif ($input == 'O') 
        {
            ksort($list);
        }
        elseif ($input == 'R') 
        {
            krsort($list);
        } 

    return $list;
        

    }

  function openfile($filename, $list) 
  {
    is_readable($filename);
    $filesize = filesize($filename);
    $read = fopen($filename, 'r');
    feof($read); 
    $todo = trim(fread($read, $filesize));
    $explotodo = explode("\n", $todo);
    foreach ($explotodo as $value) 
    {
      array_push($list, $value);
    }
    fclose($read);
    return $list;
  }


  function savefile($filename, $save) 
  {
  $handle = fopen($filename, 'w');
  $wrote = fwrite($handle, implode("\n", $save));
      if ($wrote == true) 
      {
        echo "Save was successful!\n";
      } 
      else 
      {
        echo "Save was unsuccessfull...\n";
      }
  fclose($handle);
  return $save;
  }


// The loop!
do 
{
    // Iterate through list items
    foreach ($items as $key => $item) 
    {
        // Display each item and a newline
        $key ++;
        echo "[{$key}] {$item}\n";
    }

    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort, (Q)uit, (O)pen File, S(A)ve : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(TRUE);

    // Check for actionable input
    if ($input == 'N' || $input == 'n') 
    {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $newitem = get_input(); 
        echo '(S)tart or (E)nd?';
        $input = get_input(TRUE);
        if ($input == 'S') 
        {
          array_unshift($items, $newitem);
        }  
        else 
        {
          array_push($items, $newitem);
        }


    } elseif ($input == 'R' || $input == 'r') 
    {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = get_input();
        // Remove from array
        unset($items[$key - 1]);

        }

        elseif ($input == 'S') 
        {
          $items = sort_menu($items);

        }

        elseif ($input == 'F') 
        {
          array_shift($items);
        }

        elseif ($input == 'L') 
        {
          array_pop($items);
        }

        elseif ($input == 'O') 
        {
          echo "What file do you want to open?";
          $filename = get_input();
          $items = openfile($filename, $items);
        }

         elseif ($input == 'A') 
         {
          echo "What file do you want to save to?";
          $filename = get_input();
          
          if (is_readable($filename)) 
          {
          echo "This file already exists! Would you like to overwrite it? Y/N.\n";
          $input = get_input(TRUE);

          if ($input == 'Y') 
          {
            savefile($filename, $items);

          }   
          else 
          {
          echo "File not saved.\n";
          } 

          }
        }     
    
    
// Exit when input is (Q)uit
} while ($input != 'Q' && $input != 'q');

// Say Goodbye!
echo "Goodbye!\n";



// Exit with 0 errors
exit(0);