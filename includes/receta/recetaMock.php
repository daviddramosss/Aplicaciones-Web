<?php

class recetMock implements IReceta
{
    public function create($recetaDTO)
    {
        return true;
    }

    public function edit($recetaDTO)
    {
        return true;
    }

    public function delete($recetaDTO)
    {
        return true;
    }
}
?>