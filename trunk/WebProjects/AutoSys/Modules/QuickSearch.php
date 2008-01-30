<?php
class QuickSearch extends Module {
	function QuickSearch($page){
		parent::Module($page);
		$this->side=Module::LEFT;
		$this->title="Procura";
		$this->page->addJS("ajax.js");
	}
	function content(){
		$makes=Makes::getMakes();
		$makes->asort();
		?>
<form action="<?=url("Search")?>" method="post" onsubmit="return QuickSearch.validateSubmit() || false">
	<div id="QuickSearchForm.message" style="font-weight: bold; color: red;"></div>
	<table>
		<tr>
			<td><span style="color: red;display: none;" id="QuickSearchForm.Make.error">*</span>Marca:</td>
			<td><select style="width: 120px" name="Make" id="QuickSearchForm.Make" onchange="QuickSearch.getModels()">
				<option>--Selecione--</option>
				<?php
				
				foreach ($makes as $make) {
					$n=$make['name'];
					echo "<option value=\"{$n}\">{$n}</option>";
				}
				?>
			</select>
			
			</td>
		</tr>
		<tr>
			<td>Modelo:</td>
			<td><select style="width: 120px" disabled="disabled" name="Model">
			</select></td>
		</tr>
	</table>
	<input type="text" name="test">
	<input type="submit" id="QuickSearchForm">
</form>
		<?php
	}
}
?>