<?php

use Core\Library\Request;
use Core\Library\Session;

if (!function_exists('formTitulo')) {

    /**
     * Undocumented function
     *
     * @param string $titulo
     * @param boolean $btnNovo
     * @return string
     */
    function formTitulo($titulo, $btnNovo = false)
    {
        $request = new Request();

        if ($btnNovo) {
            $cHtmlBtn = buttons("new");
        } else {
            $cHtmlBtn = buttons("voltarTitulo");
        }

        $cHtml = '<div class="row bg-primary text-white m-2">
                    <div class="col-10 p-2">
                        <h2>' . $titulo . formSubTitulo($request->getAction()) . '</h2>
                    </div>
                    <div class="col-2 text-end p-2">
                        ' . $cHtmlBtn . '
                    </div>
                </div>';

        $cHtml .= exibeAlerta();

        return $cHtml;
    }
}

if (!function_exists('formSubTitulo')) {

    /**
     * Undocumented function
     *
     * @param string $action
     * @return string
     */
    function formSubTitulo($action)
    {
        if ($action == "insert") {
            return ' - Novo';
        } elseif ($action == "update") {
            return ' - Alteração';
        } elseif ($action == "delete") {
            return ' - Exclusão';
        } elseif ($action == "view") {
            return ' - Visualização';
        } else {
            return '';
        }
    }
}

if (!function_exists('formButton')) {

    /**
     * Undocumented function
     *
     * @return string
     */
    function formButton()
    {
        static $css = false;

        $html = '';

        if (!$css) {
            $html .= '
            <style>
                .btn-custom{
                    display:inline-block;
                    padding:10px 22px;
                    border:none;
                    border-radius:10px;
                    font-size:15px;
                    font-weight:600;
                    text-decoration:none;
                    cursor:pointer;
                    transition:.25s;
                }
                .btn-orange{
                    background:#86c7df;
                    color:#fff;
                }
                .btn-orange:hover{
                    background:#86c7df;
                }
                .btn-light-orange{
                    background:#a3d1f6;
                    color:#fff;
                }
                .btn-light-orange:hover{
                    background:#86c7df;
                }
            </style>';

            $css = true;
        }

        $request = new Request();

        $html .= '<a href="' . baseUrl() . $request->getController() . '" class="btn-custom btn-light-orange">Voltar</a>';

        if ($request->getAction() != 'view') {
            $html .= '<button type="submit" class="btn-custom btn-orange ms-2">Enviar</button>';
        }

        return $html;
    }
}

if (!function_exists('buttons')) {

    /**
     * Undocumented function
     *
     * @param string $acao
     * @param integer $id
     * @return string
     */
    function buttons($acao, $id = 0, $disabled = false)
    {
        $request = new Request();
        $button = "";
        $urlButton = baseUrl() . $request->getController();

        if ($acao == "new") {
            $button .= '<a href="' . $urlButton . '/form/insert" class="btn btn-outline-info text-white" title="Novo">Novo</a>';
        } elseif ($acao == "update") {
            $button .= '<a href="' . $urlButton . '/form/update/'. $id . '" title="Alterar" style="font-size: 20px; color: #000000;"><i class="fa-solid fa-pen-to-square"></i></a>';
        } elseif ($acao == "delete") {
            if ($disabled) {
                $button .= '<span data-bs-toggle="tooltip" data-bs-title="Existem produtos vinculados">'
                         . '<button type="button" style="font-size: 20px; padding-left: 5px; color: #000000;" title="Excluir"><i class="fa-solid fa-trash"></i>'
                         . '</span>';
            } else {
                $button .= '<a href="' . $urlButton . '/form/delete/'. $id . '" style="font-size: 20px; padding-left: 7px; color: #000000;" title="Excluir"><i class="fa-solid fa-trash"></i></a>';
            }
        } elseif ($acao == "view") {
             $button .= '<a href="' . $urlButton . '/form/view/'. $id . '"style="font-size: 20px; padding-right: 7px; color: #000000;" title="Visualizar"><i class="fa-solid fa-magnifying-glass"></i></a>';
        } elseif ($acao == "voltarTitulo") {
            $button .= '<a href="' . $urlButton . '" class="btn btn-outline-info text-white" title="Voltar">Voltar</a>';
        }

        return $button;
    }

}


if (!function_exists('exibeAlerta')) {

    /**
     * Undocumented function
     *
     * @return string
     */
    function exibeAlerta()
    {
        $alertas = [
            'success' => Session::getDestroy('msgSucesso'),
            'danger'  => Session::getDestroy('msgError'),
            'warning' => Session::getDestroy('msgAlerta'),
        ];

        $html = '';

        foreach ($alertas as $classe => $mensagem) {
            if ($mensagem == '') {
                continue;
            }
            $html .= '<div class="alert alert-' . $classe . ' alert-dismissible fade show" role="alert">
                        <strong>' . $mensagem . '</strong>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }

        return $html;
    }
}

if (!function_exists('csrfField')) {
    /**
     * Retorna o <input type="hidden"> com o token CSRF atual.
     * Deve ser inserido como primeiro filho de todo <form method="POST">.
     */
    function csrfField(): string
    {
        return \Core\Library\Csrf::getHiddenField();
    }
}

if (! function_exists('datatables')) {
    /**
     * datatables
     *
     * @param string $idTable
     * @return string
     */
    function datatables($idTable)
    {
        return '
            <script src="/assests/DataTables/datatables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#' . $idTable . '").DataTable({
                        dom: "<\'mx-3\'<\'row\'<\'col-md-6\'l><\'col-md-6 d-flex justify-content-end\'f>>" +
                             "<\'row\'<\'col-sm-12\'tr>>" +
                             "<\'row\'<\'col-md-5\'i><\'col-md-7 d-flex justify-content-end\'p>>>",
                        language: {
                            "sEmptyTable":      "Nenhum registro encontrado",
                            "sInfo":            "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                            "sInfoEmpty":       "Mostrando 0 até 0 de 0 registros",
                            "sInfoFiltered":    "(Filtrados de _MAX_ registros)",
                            "sInfoPostFix":     "",
                            "sInfoThousands":   ".",
                            "sLengthMenu":      "_MENU_ resultados por página",
                            "sLoadingRecords":  "Carregando...",
                            "sProcessing":      "Processando...",
                            "sZeroRecords":     "Nenhum registro encontrado",
                            "sSearch":          "Pesquisar",
                            "oPaginate": {
                                "sNext":        "Próximo",
                                "sPrevious":    "Anterior",
                                "sFirst":       "Primeiro",
                                "sLast":        "Último"
                            },
                            "oAria": {
                                "sSortAscending":   ": Ordenar colunas de forma ascendente",
                                "sSortDescending":  ": Ordenar colunas de forma descendente"
                            }
                        }
                    });
                });
            </script>';
    }
}
