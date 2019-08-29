<?php

 class FileIterator implements SeekableIterator
 {
     private $position; //row number in file
     private $handle;
     private $filesize;
     private $rows = [];

     public function __construct($path)
     {
         $this->rewind();
         $this->setFile($path);
     }

     /* Метод, требуемый для интерфейса SeekableIterator */

    public function seek($position) {
      if ($position<0 || $position >= $this->getFileSize()) {
          throw new OutOfBoundsException("недействительная позиция ($position)");
      }

      $this->position = $position;
    }

    /*  Методы, требуемые для интерфейса Iterator */

    public function rewind() {
       $this->position = 0;
    }

    public function current() {
       return $this->getFileRow($this->position);
    }

    public function key() {
       return $this->position;
    }

    public function next() {
       ++$this->position;
    }

    public function valid() {
       return ($this->position > 0 && $this->position < $this->getFileSize());
    }

    public function setFile ($path)
    {
        $this->filesize = 0;
        $this->handle = fopen($path, "r");

        while(fgets($this->handle) !== false) {
            $this->rows[] = ftell($this->handle);
            ++$this->filesize;
        }
    }

    public function getFileSize()
    {
        return $this->filesize;
    }

    public function getFileRow(int $position)
    {
        if ($position >= $this->getFileSize()) {
            throw new \Exception('Wrong position');
        }
        if ($position === 0){
            fseek($this->handle, 0);
        } else {
            fseek($this->handle, $this->rows[$position - 1]);
        }
        return rtrim(fgets($this->handle), PHP_EOL);
    }
}
