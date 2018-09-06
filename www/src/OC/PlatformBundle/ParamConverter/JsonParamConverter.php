<?php

namespace OC\PlatformBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JsonParamConverter implements ParamConverterInterface
{
	function supports(ParamConverter $configuration)
	{
		// Si le nom de l'argument du contrôleur n'est pas "json", on n'applique pas le convertisseur
		if ('json' !== $configuration->getName()) {
			return false;
		}

		return true;  	
	}

	function apply(Request $request, ParamConverter $configuration)
	{
    // On récupère la valeur actuelle de l'attribut
    $json = $request->attributes->get('json');

    // On effectue notre action : le décoder
    try{
    	$json = json_decode($json, true);
    }catch(\Exception $e){
    	throw new NotFoundHttpException(sprintf('Invalid JSON given for parameter "%s".', $json));
    }

    // On met à jour la nouvelle valeur de l'attribut
    $request->attributes->set('json', $json);

    return true;
	}
}
