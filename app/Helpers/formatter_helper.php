<?php

if (! function_exists('set_status'))
{
	function set_status(string $value, array $row): string
	{
		return $value === '1' ? 'Active' : 'Inactive';
	}
}

if (! function_exists('action_links'))
{
	function action_links(string $value, array $row): string
	{
		return '<a href="'.base_url('customers/'.$value).'">GÖRÜNTÜLE</a>';
	}
}

if (! function_exists('user_card'))
{
	function user_card(string $value, array $row): string
	{
        return  '<div class="user-card">
        <div class="user-avatar bg-secondary-dim sq">
            <span>'.substr($value, 0, 1).'</span>
        </div>
        <div class="user-info">
            <a href="'.base_url('customers/'.$value).'" style="color:inherit;">
                <span class="tb-lead"><span class="dot dot-warning d-md-none ms-1"></span></span>
                <span class="">'.$value.'</span>
            </a>
        </div>
    </div>';
	}
}

if (! function_exists('checks'))
{
	function checks(string $value, array $row): string
	{
        return  '<div class="custom-control custom-control-sm custom-checkbox notext">
                    <input type="checkbox" class="custom-control-input" id="uid_'.$value.'">
                    <label class="custom-control-label" for="uid_'.$value.'"></label>
                </div>';
	}
}


