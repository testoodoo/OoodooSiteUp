<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
           <a href="/data_usage">
           <div class="symbol blue">
              <i class="fa fa-download" ></i>
          </div>
          <div class="value">
              <h4 class="count">{{Auth::user()->get()->data_usage_in_gb()}} GB</h4>
              <p>Data Used</p>
          </div></a>
         </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
           <a href="/topup">
           <div class="symbol yellow">
              <i class="fa fa-file-o"></i>
           </div>
          <div class="value">
              <h4 class="count4">{{Auth::user()->get()->plan()->plan}}</h4>
              <p>Plan</p>
          </div></a>
         </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bars"></i>
            </div>
            <div class="value">
                <h4 class=" count4">{{Auth::user()->get()->data_duration()}}</h4>
                <p>Data Cycle</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="value">
                <h7 class="count4">From : {{Auth::user()->get()->jsubs()->plan_start_date}}</h7><br>
                <h7 class="count4">To : {{Auth::user()->get()->jsubs()->plan_end_date}}</h7>
                <p>Plan Duration</p>
            </div>
        </section>
    </div>
</div>
