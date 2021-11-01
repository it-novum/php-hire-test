<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recipe[]|\Cake\Collection\CollectionInterface $recipes
 */
?>
<h1 class="page-header">Mothers Finest</h1>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Neues Rezept'), ['action' => 'add'], ['class' => 'nav-link h6 btn-secondary', 'style' => 'color:white;']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>
<legend><?= __('Rezepte') ?></legend>
<row>
    <form>
    <input type="text" class="float-right" id="finder" style="margin-bottom: 5px;" size="50" name="search" placeholder="Suche nach Namen, Suche mit Enter ausführen" value="" onchange="this.form.submit()">
        <button class="btn-primary float-right" onclick="this.location.reload()">Reset/Enter</button>
    </form>
</row>
<table class="table table-striped table-bordered" id="recipeTable">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created', 'Erstellung') ?></th>
        <!--<th scope="col">Beschreibung</th>-->
        <th scope="col" class="actions" style="width:25%"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($recipes as $recipe) : ?>
        <tr data-toggle="hover" title="Bei Klick in der Namensspalte bekommen Sie das Rezept angezeigt">
            <td><?= $this->Number->format($recipe->id) ?></td>
            <td data-toggle="modal" data-target="#basicModal" data-id=<?= $recipe->id ?>><u><?= h($recipe->name) ?></u></td>
            <td><?= h(\date_format($recipe->created, 'd.m.Y H:i:s')) ?></td>
            <!--<td><?= h($recipe->description) ?></td>-->
            <td class="actions" style="width:10%">
               <!-- <?= $this->Html->link(__('View'), ['action' => 'view', $recipe->id], ['title' => __('View'), 'class' => 'btn btn-secondary']) ?>-->
                <?= $this->Html->link(__('Bearbeiten'), ['action' => 'edit', $recipe->id], ['title' => __('Bearbeiten'), 'class' => 'btn btn-secondary']) ?>
                <a class="btn btn-info" href="#" data-toggle="email" data-target="#emailModal" data-id=<?= $recipe->id ?>>Email</a>
                <?= $this->Form->postLink(__('Löschen'), ['action' => 'delete', $recipe->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recipe->id), 'title' => __('Delete'), 'class' => 'btn btn-danger']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator clearfix">
    <span>
        <p class="float-left"><?= $this->Paginator->counter(__('Seite {{page}} von {{pages}}, zeigt {{current}} record(s) von {{count}} total')) ?></p>
    </span>
    <span>
    <ul class="pagination float-right">
        <?= $this->Paginator->first('<< ' . __('')) ?>
        <?= $this->Paginator->prev('< ' . __('')) ?>
        <?= $this->Paginator->numbers(['vor' => '', 'nach' => '']) ?>
        <?= $this->Paginator->next(__('') . ' >') ?>
        <?= $this->Paginator->last(__('') . ' >>') ?>
    </ul></span>
</div>

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Rezept</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ajax">
                <input type="hidden" id="recipeId" name="recipeId" value="">
                <div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schliessen</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Rezept per Email versenden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body email">
                <form id="emailForm">
                    <input type="hidden" id="recipeId" name="recipeId" value="">
                    <div class="form-group">
                        <label for="exampleInputEmail">Emailempfänder</label>
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail"  aria-describedby="emailHelp" required>
                        <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                    </div>
                    <div id="output"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary float-right" style="margin-right: 10px" data-dismiss="modal">Schliessen</button>
                    <button type="submit" class="btn btn-primary float-right">Senden</button>
                    </div>
                </form>
            </div>
            <!--<div class="modal-footer">
            </div>-->
        </div>
    </div>
</div>

<script src="/bootstrap_u_i/js/jquery.js"></script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="modal"]').on('click', function () {
       // $('[data-toggle="modal"]').hover( function () {
            var id = $(this).data('id');
            var modalId = $(this).data('target');
            $(modalId).find('#recipeId').val(id);
            $.ajax({
                type: "post",
                url: "/recipes/ajax/" + id
            }).done(function (data) {
                var html = data.html;
                $('.ajax').html();
                $('.ajax').html(html);
                //console.log(data.html);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                    $('.modal-body').html('<div style="color:red;">Ups!</div><div>Ein Fehler ist passiert</div>');
            });

            $(modalId).modal('show');
        });

        $('[data-toggle="email"]').on('click', function () {
            var id = $(this).data('id');
            var modalId = $(this).data('target');
            $(modalId).find('#recipeId').val(id);
            $(modalId).modal('show');
        });

        $('#emailModal').on('shown.bs.modal', function () {
            $('#inputEmail').trigger('focus')
        });

        $( "#emailForm" ).submit(function( event ) {
            event.preventDefault();
            var form = $("#emailForm").serializeArray();
            $.ajax({
                type: "post",
                url: "/recipes/email",
                data: form
            }).done(function (data) {
                $('#emailModal').modal('hide');
                location.reload();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                $('.email').html('<div style="color:red;">Ups!</div><div>Ein Fehler ist passiert</div>');
            });
        });
    });
</script>


