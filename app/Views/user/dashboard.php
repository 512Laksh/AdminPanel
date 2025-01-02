<?= $this->extend('user/layout.php');?>
<?= $this->section('content');?>
        <section>
            <div class="cards">
                <div class="card">
                    <h5>150</h5>
                    <p>Logged Agents</p>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="card">
                    <h5>Call Answered</h5>
                    <p>75</p>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="card">
                    <h5>Missed Calls</h5>
                    <p>10</p>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="card">
                    <h5>New Signups</h5>
                    <p>10</p>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </section>
<?= $this->endSection('content');?>

   