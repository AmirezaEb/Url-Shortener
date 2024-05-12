<?php

/* 
Developed by Hero Expert
Telegram channel : HeroExpert_ir
*/

# Create A Short Url
function shortUrlCreate()
{
    $length = rand(3, 7);
    $characters = 'aA0bBcC1dDeE2fFgG3hHiI4jJkK5lLmM6nNoO7pPqQ8rRsS9tTuUvVwWxXyYzZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

# Save The Url Information In The DataBase
function saveUrl($Url, $shortUrl)
{
    global $table;
    global $connect;
    $sql = "INSERT INTO $table (url,shortUrl) VALUES (:url,:shortUrl);";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':url' => $Url, ':shortUrl' => $shortUrl,]);
    $result = $stmt->rowCount();
    return $result;
}

# Get Information About The Existence Of A ShortUrl
function receiveShortUrlCount($Url)
{
    global $table;
    global $connect;
    $sql = "SELECT * FROM $table WHERE shortUrl = :shortUrl;";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':shortUrl' => $Url]);
    $result = $stmt->rowCount();
    return $result;
}

# Get Information About The Existence Of A Url
function receiveUrlCount($Url)
{
    global $table;
    global $connect;
    $sql = "SELECT * FROM $table WHERE url = :url;";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':url' => $Url]);
    $result = $stmt->rowCount();
    return $result;
}

# Get Information About The Existence Of A ShortUrl
function receiveShortUrl($ShortUrl)
{
    global $table;
    global $connect;
    $sql = "SELECT * FROM $table WHERE shortUrl = :shortUrl;";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':shortUrl' => $ShortUrl]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $result = $result['url'];
    return $result;
}

# Get Information About The Existence Of A Url
function receiveUrl($Url)
{
    global $table;
    global $connect;
    $sql = "SELECT * FROM $table WHERE url = :url;";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':url' => $Url]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $result = $result['shortUrl'];
    return $result;
}

# Redirect The User
function redirect($Url)
{
    if (!headers_sent()) {
        header("Location: $Url");
    } else {
        echo "<script type='text/javascript'>window.location.href='$Url'</script>";
        echo "<noscript><meta http-equiv='refresh' content='0;url=$Url'/></noscript>";
    }
    exit;
}

# Display Messages To The User
function alarm($mode, $message)
{
    $alarm = "<script>
    Swal.fire({
        title: '$message',
        icon: '$mode',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    })
    </script>";
    return $alarm;
}

/* 
Developed by Hero Expert
Telegram channel : HeroExpert_ir
*/
?>