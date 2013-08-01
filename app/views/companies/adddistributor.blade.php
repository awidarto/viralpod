
{{Former::vertical_open_for_files('companies/addagent','POST',array('class'=>'vertical'))}}

<div class="row">
    <div class="span5">
        {{ Former::select('agentCategory','Category')->options(Config::get('se.agent_categories')) }}
        {{ Former::text('location','Address') }}
        {{ Former::text('email','Email (Main)') }}
        {{ Former::text('phone','Phone') }}
        {{ Former::text('fax','Fax') }}

    </div>
    <div class="span5">
        {{ Former::select('country')->options(Config::get('country.countries'))->label('Country') }}
        {{ Former::select('city')->options(Config::get('city.cities'))->label('City') }}
        {{ Former::select('region[]')->options(Config::get('region.regions'))->name('region')->multiple(true)->label('Region Covered') }}
        {{ Former::select('countryCoveredAgent')->options(Config::get('country.countries'))->label('Country Covered (agent)') }}

        {{ Former::text('specificLocalRegionAgent','Specific Local Region (agent)') }}
    </div>
</div>

{{Former::close()}}
