{%-macro value_or_dash(value) %}
    {% if value is empty %}
        <span class="text-muted">&#0151;</span>
    {% else %}
        {{ value }}
    {% endif %}
{% endmacro-%}

{%-macro xeditable_input(type, name, id, data) %}
    <a class="editable {{ name }}"
       data-name="{{ name }}"
       data-pk='{{ id }}'
       data-value='{% if data is scalar %}{{ data }}{% else %}{{ data|json_encode }}{% endif %}'
       data-type="{{ type }}"
       href="#"></a>
{% endmacro-%}

{%- macro page_header(text, icon, _trans) %}
    <h1 class="page-header">{% if icon %}<i class="{{ icon }} icon-large text-muted"></i>&nbsp;{% endif %}{{ _trans._(text) }}</h1>
{%- endmacro %}
