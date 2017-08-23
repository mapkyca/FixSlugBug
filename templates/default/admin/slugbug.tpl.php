

<div class="row">

    <div class="col-md-10 col-md-offset-1">
        <?= $this->draw('admin/menu') ?>
        <h1>Course Group ID reset</h1>
    </div>

</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form action="<?= \Idno\Core\site()->config()->getURL() ?>admin/slugbug/" class="form-horizontal" method="post">


            <div class="controls-group">
                <p>
                    Fix the slug bug error fixed by #1864. Please make sure you have performed a full database backup prior to running this script!
                </p>

                <p>
                    <label class="control-label" for="domain">Dry run and review changes?</label>
                    <input type="checkbox"  class="form-control" name="dryrun" value="true" >
                </p>
                
            </div>


            <div class="controls-group">
                <div class="controls-save">
                    <button type="submit" class="btn btn-primary">Go</button>
                </div>
            </div>
            <?= \Idno\Core\site()->actions()->signForm('/admin/setgroup/') ?>
        </form>
	
    </div>
    
    
</div>