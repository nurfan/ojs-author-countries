{**
* plugins/blocks/authorCountries/block.tpl
*
* Copyright (c) 2019 Gunali Rezqi Mauludi
* Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
*
* Common site sidebar menu -- country toggle.
*}

{if $enableAuthorCountries}
{if $displayAuthorCountries}
<link rel="stylesheet" type="text/css" href="{$authorCountriesStyle}" />
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" /> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.3.1/css/flag-icon.min.css" rel="stylesheet" />

<div class="pkp_block block_country">
  <div class="panel panel-primary">
    <div class="panel-heading">Issue Coverage<br>(77 Authors)</div>
    <table style="margin: 1em 0.25em 0.5em; width: inherit;">
      <tr>
        <td colspan="4" style="text-align: center; font-weight: bold; background-color: #ddd;">Total 4 Author's Countries</td>
      </tr>
      <tr class="panel-body">
        <td width="10%" style="padding-top: 7px;"><span class="flag-icon flag-icon-gf" style="border: 1px solid #ccc"></span></td>
        <td width="78%">Indonesia</td>
        <td width="12%" style="text-align: center;">(12)</td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: center; font-weight: bold;">{$authMark}</td>
      </tr>
    </table>
  </div>
</div><!-- .block_country -->
{/if}
{/if}