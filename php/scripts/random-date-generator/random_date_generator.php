<?php

class RandomDateGenerator
{
    private int $diffDayNum;
    public array $cacheArray;

    public function __construct(DateTimeImmutable $start, DateTimeImmutable $end, string $format = null)
    {
        $this->diffDayNum = $start->diff($end)->days;
        $d = $start;
        for ($i = 0; $i < $this->diffDayNum; $i++) {
            $this->cacheArray[] = $format === null ? $d : $d->format($format);
            $d = $d->modify("+1day");
        }
        $this->cacheArray[] = $d->format($format);
    }

    public static function fromString(string $start, string $end, string $format = null): self
    {
        return new self(new DateTimeImmutable($start), new DateTimeImmutable($end), $format);
    }

    public function get(): DateTimeImmutable|string
    {
        return $this->cacheArray[random_int(0, $this->diffDayNum - 1)];
    }
}


$g = RandomDateGenerator::fromString("2021-03-10", "2021-03-13", "Y-m-d");
