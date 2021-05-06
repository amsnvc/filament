<?php

namespace Filament\Forms\Components;

class DatePicker extends Field
{
    use Concerns\CanBeAutofocused;
    use Concerns\CanBeCompared;
    use Concerns\CanBeUnique;
    use Concerns\HasPlaceholder;

    protected $displayFormat;

    protected $format;

    protected $hasSeconds = true;

    protected $hasTime = false;

    protected $maxDate;

    protected $minDate;

    protected $view = 'forms::components.date-time-picker';

    protected string $locale;

    protected int $firstDayOfWeek;

    protected function setUp()
    {
        $this->configure(function () {
            $this->displayFormat('F j, Y');
            $this->format('Y-m-d');
            $this->firstDayOfWeek = config('forms.first-day-of-week');
        });
    }

    public function displayFormat($format)
    {
        $this->configure(function () use ($format) {
            $this->displayFormat = $format;
        });

        return $this;
    }

    public function format($format)
    {
        $this->configure(function () use ($format) {
            $this->format = $format;
        });

        return $this;
    }

    public function getDisplayFormat()
    {
        return $this->displayFormat;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getMaxDate()
    {
        return $this->maxDate;
    }

    public function getMinDate()
    {
        return $this->minDate;
    }

    public function getFirstDayOfWeek()
    {
        return $this->firstDayOfWeek;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function hasSeconds()
    {
        return $this->hasSeconds;
    }

    public function hasTime()
    {
        return $this->hasTime;
    }

    public function maxDate($date)
    {
        $this->configure(function () use ($date) {
            $this->maxDate = $date;

            $this->addRules([$this->getName() => ["before_or_equal:{$date}"]]);
        });

        return $this;
    }

    public function minDate($date)
    {
        $this->configure(function () use ($date) {
            $this->minDate = $date;

            $this->addRules([$this->getName() => ["after_or_equal:{$date}"]]);
        });

        return $this;
    }

    /**
     * Default = app()->getLocale()
     * DayJS i18 via browser: https://day.js.org/docs/en/i18n/loading-into-browser
     * Available methods: https://day.js.org/docs/en/plugin/locale-data
     * Supported locales: https://github.com/iamkun/dayjs/tree/dev/src/locale
     * @param string $dayJSlocale
     * @return $this
     */
    public function locale(string $dayJSlocale): self
    {
        $this->locale = $dayJSlocale;
        return $this;
    }

    /**
     * 0 to 7 are allowed. Monday = 1, Sunday = 0 or 7
     * @param int $day
     * @return $this
     */
    public function firstDayOfWeek(int $day = 1): self
    {
        if($day < 0 || $day > 7) $day = 1;
        $this->firstDayOfWeek = $day;
        return $this;
    }

    /**
     * Set Sunday as first day of week
     * @return $this
     */
    public function weekStartSunday(): self
    {
        $this->firstDayOfWeek = 7;
        return $this;
    }

    /**
     * This method is otiose because Monday is default
     * <br>But sometimes you want it for code readability
     * @return $this
     */
    public function weekStartMonday(): self
    {
        $this->firstDayOfWeek = 1;
        return $this;
    }
}
