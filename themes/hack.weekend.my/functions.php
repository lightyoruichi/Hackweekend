<?php

class Hackweekend {

  function participant_shortcode($atts) {
    extract($atts);

    return <<<HTML
      <a href="{$href}" class="alignleft" alt="{$name}" title="{$name}"><img src="https://api.twitter.com/1/users/profile_image/{$twitter}?size=normal" alt="{$name}" title="{$name}"/></a>
      <div>
        <strong><a href="{$href}" alt="{$name}" title="{$name}">{$name}</a></strong>
        <em>({$role})</em>
      </div>
      <a href="http://www.facebook.com/{$facebook}">Facebook</a> &middot;
      <a href="http://www.twitter.com/{$twitter}">Twitter</a>
      <a href="http://www.twitter.com/{$twitter}">@{$twitter}</a>
      <div class="clear"></div>
HTML;
  }

  function team_shortcode($atts) {
    extract($atts);

    $links = array();
    if (isset($url)) {
      $domain = parse_url($url, PHP_URL_HOST);
      if (strpos($domain, "www.") === 0) {
        $domain = substr($domain, 4);
      }
      $links[] = "<a href=\"{$url}\">{$domain}</a>";
    }

    if (isset($facebook)) {
      $links[] = "<a href=\"{$facebook}\">Facebook</a>";
    }

    if (isset($twitter)) {
      $links[] = "<a href=\"http://www.twitter.com/{$twitter}\">Twitter</a> <a href=\"http://www.twitter.com/{$twitter}\">@{$twitter}</a>";
    }

    $links = implode(' &middot; ', $links);
    return <<<HTML
      <h2 style="display: inline" id="{$id}" ><a href="{$url}">{$name}</a></h2>
      {$links}
HTML;
  }

  function looking_for_shortcode($atts) {
    extract($atts);

    return <<<HTML
      <img src="http://hack.weekend.my/wp-content/themes/hack.weekend.my/images/add.png" alt="Looking for {$role}" title="Looking for {$role}" style="width: 48px; height: 48px}" class="alignleft" />
      <strong>Looking for {$role}</strong>
      <div class="clear"></div>
HTML;
  }

  function session_shortcode($atts, $content = null) {
    extract($atts);

    return "<strong>{$time}</strong> &mdash; {$content}";
  }

}

add_shortcode('participant', array('Hackweekend', 'participant_shortcode'));
add_shortcode('looking_for', array('Hackweekend', 'looking_for_shortcode'));
add_shortcode('team', array('Hackweekend', 'team_shortcode'));
add_shortcode('session', array('Hackweekend', 'session_shortcode'));
