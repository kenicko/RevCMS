<?php
/**
 * @author Jos Piek
 */
	require_once 'xmlToArrayParser.php';
	class Library_HabboFigure extends Library_xmlToArrayParser
	{
		private $colors;
		private $setscolors;
		private $sets;
		
		public function __construct($xmlfile)
		{
			parent::__construct(file_get_contents($xmlfile));
			
			if ($this->parse_error)
			{
				exit( $this->get_xml_error() );
			}
			
			//lets set the colors
			//echo nl2br(print_r($this->array['figuredata']['colors']['palette']['0'], true));
			foreach ($this->array['figuredata']['colors']['palette'] as $palette)
			{
				$this->colors[$palette['attrib']['id']] = $this->FilterParseColors($palette['color']);
			}
			//echo nl2br(print_r($this->colors, true));
			
			//lets set the sets
			//echo nl2br(print_r($this->array['figuredata']['sets']['settype']['0'], true));
			foreach ($this->array['figuredata']['sets']['settype'] as $settype)
			{
				$type = $settype['attrib']['type'];
				$paletteid = $settype['attrib']['paletteid'];
			
				$this->setscolors[$type] = $paletteid;
				
				$this->sets[$type] = $this->FilterParseSets($settype['set']);
			}
			//echo nl2br(print_r($this->sets, true));
		}
		
		private function FilterParseColors($colors)
		{
			$result = array();
		
			foreach ($colors as $color)
			{
				$id = $color['attrib']['id'];
				$color['attrib']['color'] = $color['cdata'];
				
				$result[$id] = $color['attrib'];
			}
			
			return $result;
		}
		
		private function FilterParseSets($sets)
		{
			$result = array();
			
			foreach ($sets as $set)
			{
				$id = $set['attrib']['id'];
				$result[$id] = $set['attrib'];
			}
			
			return $result;
		}
		
		public function ValidateFigure($gender, $figure, $vip = false, $club = false, $ignoreselectable = true)
		{
			$settypes = explode('.', $figure);
			
			foreach ($settypes as $settype)
			{
				list ($type, $id, $colorid) = explode('-', $settype);
				
				if (!isset($this->sets[$type]))
				{
					return false;
				}
				
				if (!isset($this->sets[$type][$id]))
				{
					return false;
				}
				
				$set = $this->sets[$type][$id];
				$paletteid = $this->setscolors[$type];
				
				if ($set['gender'] != $gender && $set['gender'] != 'U')
				{
					return false;
				}
				
				
			
				if ($set['selectable'] == '0' && !$ignoreselectable)
				{
					return false;
				}
				
				if ($set['colorable'] == '1' && isset($colorid))
				{
					if (!isset($this->colors[$paletteid]))
					{
						return false;
					}
				
					if (!isset($this->colors[$paletteid][$colorid]))
					{
						return false;
					}
				
					$color = $this->colors[$this->setscolors[$type]][$colorid];
				
					if ($color['selectable'] == '0' && !$ignoreselectable)
					{
						return false;
					}
				}
				
				if ($set['colorable'] == '0' && isset($colorid))
				{
					return false;
				}
				
				if ($vip || $club)
				{
					$maxclub = ($vip) ? 2 : 1;
					
					if ($set['club'] > $maxclub)
					{
						return false;
					}
					
					if ($color['club'] > $maxclub && $set['colorable'] == '1' && isset($colorid))
					{
						return false;
					}
				}
				else if ($set['club'] != '0')
				{
					return false;
				}
			}
			
			return true;
		}
		
		public function RandomFigure($gender = 'M', $vip = false, $club = false, $extratypes = array())
		{
			$types = array_merge(array('hr', 'hd', 'lg', 'ch', 'sh'), $extratypes);
			
			$i = -1;
			$result = array();
			foreach ($types as $type)
			{
				$i++;
				
				$paletteid = $this->setscolors[$type];
				
				$maxclub = 0;
				if ($vip || $club)
				{
					$maxclub = ($vip) ? 2 : 1;
				}
				
				$tempsets = array_filter($this->sets[$type], function ($set) use ($gender, $maxclub) {
				
					return ($set['gender'] == $gender || $set['gender'] == 'U') && $set['club'] <= $maxclub && $set['selectable'] == '1';
				
				});
				
				$id = array_rand($tempsets);
				
				$result[$i] = $type . '-' . $id;
				
				if ($this->sets[$type][$id]['colorable'] == '0')
				{
					continue;
				}
				
				$tempcolors = array_filter($this->colors[$paletteid], function ($color) use ($maxclub) {
				
					return $color['club'] <= $maxclub && $color['selectable'] == '1';
				
				});
				
				
				$result[$i] .= '-' . array_rand($tempcolors);
			}

			return implode('.', $result);
		}
	}

?>