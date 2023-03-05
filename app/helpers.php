<?php
function active_link(string $name): bool
{
  return request()->routeIs($name);
}
