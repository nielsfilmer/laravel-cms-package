<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::label($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
    <div class="input-group">
        <div class="input-group-addon">&euro;</div>
        <?= Form::input($type, $name, $options['value'], $options['attr']) ?>
    </div>

    @include('laravel-form-builder::help_block')
<?php endif; ?>

@include('laravel-form-builder::errors')

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
