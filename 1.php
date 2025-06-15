<?php
abstract class Book {
    protected $title;
    protected $author;
    protected $year;
    protected $readCount = 0;
    
    public function __construct($title, $author, $year) {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
    }
    
    abstract public function getBook();
    
    public function incrementReadCount() {
        $this->readCount++;
    }
    
    public function getReadStatistics() {
        return "Книга '{$this->title}' прочитана {$this->readCount} раз(а)";
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getAuthor() {
        return $this->author;
    }
    
    public function getYear() {
        return $this->year;
    }
}

class DigitalBook extends Book {
    private $downloadLink;
    
    public function __construct($title, $author, $year, $downloadLink) {
        parent::__construct($title, $author, $year);
        $this->downloadLink = $downloadLink;
    }
    
    public function getBook() {
        $this->incrementReadCount();
        return "Ссылка для скачивания: {$this->downloadLink}";
    }
}

class PaperBook extends Book {
    private $libraryAddress;
    private $shelfNumber;
    
    public function __construct($title, $author, $year, $libraryAddress, $shelfNumber) {
        parent::__construct($title, $author, $year);
        $this->libraryAddress = $libraryAddress;
        $this->shelfNumber = $shelfNumber;
    }
    
    public function getBook() {
        $this->incrementReadCount();
        return "Книга доступна по адресу: {$this->libraryAddress}, полка №{$this->shelfNumber}";
    }
}

class BookShelf {
    private $shelfNumber;
    private $capacity;
    private $books = [];
    
    public function __construct($shelfNumber, $capacity) {
        $this->shelfNumber = $shelfNumber;
        $this->capacity = $capacity;
    }
    
    public function addBook(Book $book) {
        if (count($this->books) < $this->capacity) {
            $this->books[] = $book;
            return true;
        }
        return false;
    }
    
    public function removeBook($title) {
        foreach ($this->books as $key => $book) {
            if ($book->getTitle() === $title) {
                unset($this->books[$key]);
                return true;
            }
        }
        return false;
    }
    
    public function getBooksList() {
        return $this->books;
    }
}

// Пример использования
$digitalBook = new DigitalBook("PHP для профессионалов", "Джон Дакетт", 2020, "https://example.com/php-book");
$paperBook = new PaperBook("Совершенный код", "Стив Макконнелл", 2010, "ул. Ленина, 15", 42);

echo $digitalBook->getBook() . "\n";
echo $paperBook->getBook() . "\n";

$digitalBook->incrementReadCount();
$digitalBook->incrementReadCount();
echo $digitalBook->getReadStatistics() . "\n";

$shelf = new BookShelf(42, 50);
$shelf->addBook($paperBook);
print_r($shelf->getBooksList());
?>