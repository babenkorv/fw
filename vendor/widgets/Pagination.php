<?php
namespace vendor\widgets;

class Pagination
{
    private $maxCountLink = 10;

    private $maxCountRows = 10;

    private $countRows;

    private $curPage;

    private $countLink;

    private $model;

    /**
     * Pagination constructor.
     * @param object $model model data to paginate.
     * @param int $countRows count show rows in table.
     * @param int $countLink count show nav bar link.
     */
    public function __construct($model, $countRows = 10, $countLink = 5)
    {
        $this->curPage = (isset($_GET['current_page'])) ? $_GET['current_page'] : 1;
        $this->maxCountLink = $countLink;
        $this->maxCountRows = $countRows;
        $this->model = $model;
    }

    /**
     * Set count rows in table and calculate count link buttons.
     */
    public function pagination()
    {
        $this->countRows = $this->model->countAllRows();
        $this->countLink = ceil($this->countRows / $this->maxCountRows);
    }

    /**
     * Return model with pagination.
     *
     * @return mixed
     */
    public function model()
    {
        $this->pagination();
        return $this->model->limit($this->maxCountRows)->offset($this->curPage * $this->maxCountRows - $this->maxCountRows);
    }

    /**
     * Create links on pagination page.
     *
     * @param int $page
     * @return string
     */
    public function createLink($page) {

        $oldLink = $_SERVER['REQUEST_URI'];
        $newLink = str_replace('current_page='. $this->curPage, 'current_page='.$page, $_SERVER['REQUEST_URI']);

        if($oldLink == $newLink) {
            $newLink = $newLink . '?current_page='  . $page;
        }
        
        return $newLink;
    }

    /**
     * Return string with html code navBar.
     *
     * @return string
     */
    public function navBar()
    {
        $navBar = '<ul class="pagination">';

        if ($_GET['current_page'] > 1) {
            $navBar .= '<li class="page-item">';
            $navBar .= '<a href="' . $this->createLink($this->curPage - 1) . '">' . '<<' . "</a>";
            $navBar .= '</li>';
        } else {
            $navBar .= '<li class="page-item">';
            $navBar .= '<a class="disabled"  href="' . $this->createLink($this->curPage - 1). '">' . '<<' . "</a>";
            $navBar .= '</li>';
        }

        $startButton = $this->curPage - floor($this->maxCountLink/2);
        $endButton = $startButton + $this->countLink;
        if($startButton <= 0) {
            $startButton = 1;
            $endButton = $startButton + $this->countLink;
        }

        if($startButton >= $this->countLink) {
            $startButton = $this->countLink - $this->curPage;
        }

        if($endButton >= $this->countLink) {
            $endButton = $this->countLink;
        }

        for ($i = $startButton; $i <= $endButton; $i++) {
            if($i == $this->curPage) {
                $navBar .= '<li class="page-item active">';
                $navBar .= '<a href="' . $this->createLink($i) . '">' . $i . "</a>";
                $navBar .= '</li>';
            } else {
                $navBar .= '<li class="page-item">';
                $navBar .= '<a href="' . $this->createLink($i) . '">' . $i . "</a>";
                $navBar .= '</li>';
            }
        }

        if ($_GET['current_page'] < $this->countLink) {
            $navBar .= '<li class="page-item">';
            $navBar .= '<a href="' . $this->createLink($this->curPage + 1) . '">' . '>>' . "</a>";
            $navBar .= '</li>';
        } else {
            $navBar .= '<li class="page-item">';
            $navBar .= '<a class="disabled"  href="' .$this->createLink($this->curPage + 1) . '">' . '>>' . "</a>";
            $navBar .= '</li>';
        }
        $navBar .= '</ul>';

        return $navBar;
    }
}