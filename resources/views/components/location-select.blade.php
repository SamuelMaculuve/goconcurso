{{--
  Componente reutilizável de país + cidade
  Props:
    countryName   - name do input country (default: 'country')
    cityName      - name do input city    (default: 'city')
    countryValue  - valor actual do país
    cityValue     - valor actual da cidade
    required      - se os campos são obrigatórios
    ringColor     - classe de foco (default: focus:ring-terracota/30)
    borderFocus   - classe border foco (default: focus:border-terracota)
    labelCountry  - label do país
    labelCity     - label da cidade
--}}
@props([
    'countryName'  => 'country',
    'cityName'     => 'city',
    'countryValue' => '',
    'cityValue'    => '',
    'required'     => false,
    'ringColor'    => 'focus:ring-terracota/30',
    'borderFocus'  => 'focus:border-terracota',
    'labelCountry' => 'País',
    'labelCity'    => 'Cidade',
])

@php
$selectClass = "w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 {$ringColor} {$borderFocus} transition";
@endphp

<div x-data="locationSelect('{{ addslashes($countryValue) }}', '{{ addslashes($cityValue) }}')" class="contents">

    {{-- País --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            {{ $labelCountry }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
        <select
            name="{{ $countryName }}"
            x-model="country"
            @change="onCountryChange()"
            {{ $required ? 'required' : '' }}
            class="{{ $selectClass }}">
            <option value="">Seleccionar país</option>
            <optgroup label="🌍 África Austral">
                <option value="Moçambique">Moçambique</option>
                <option value="Angola">Angola</option>
                <option value="África do Sul">África do Sul</option>
                <option value="Zimbabué">Zimbabué</option>
                <option value="Zâmbia">Zâmbia</option>
                <option value="Malawi">Malawi</option>
                <option value="Namíbia">Namíbia</option>
                <option value="Botswana">Botswana</option>
                <option value="Lesoto">Lesoto</option>
                <option value="Suazilândia">Suazilândia (Eswatini)</option>
                <option value="Madagáscar">Madagáscar</option>
                <option value="Ilhas Maurício">Ilhas Maurício</option>
                <option value="Comores">Comores</option>
            </optgroup>
            <optgroup label="🌍 África Oriental">
                <option value="Tanzânia">Tanzânia</option>
                <option value="Quénia">Quénia</option>
                <option value="Uganda">Uganda</option>
                <option value="Ruanda">Ruanda</option>
                <option value="Burundi">Burundi</option>
                <option value="Etiópia">Etiópia</option>
                <option value="Somália">Somália</option>
                <option value="Djibuti">Djibuti</option>
                <option value="Eritreia">Eritreia</option>
            </optgroup>
            <optgroup label="🌍 África Ocidental">
                <option value="Nigéria">Nigéria</option>
                <option value="Ghana">Ghana</option>
                <option value="Senegal">Senegal</option>
                <option value="Costa do Marfim">Costa do Marfim</option>
                <option value="Camarões">Camarões</option>
                <option value="Guiné-Bissau">Guiné-Bissau</option>
                <option value="Guiné Equatorial">Guiné Equatorial</option>
                <option value="São Tomé e Príncipe">São Tomé e Príncipe</option>
                <option value="Cabo Verde">Cabo Verde</option>
                <option value="Mali">Mali</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Togo">Togo</option>
                <option value="Benim">Benim</option>
                <option value="Libéria">Libéria</option>
                <option value="Serra Leoa">Serra Leoa</option>
                <option value="Gâmbia">Gâmbia</option>
                <option value="Mauritânia">Mauritânia</option>
                <option value="Niger">Niger</option>
            </optgroup>
            <optgroup label="🌍 África Central e Norte">
                <option value="Congo (RD)">Congo (RD)</option>
                <option value="Congo (Rep.)">Congo (República)</option>
                <option value="Gabão">Gabão</option>
                <option value="República Centro-Africana">República Centro-Africana</option>
                <option value="Chade">Chade</option>
                <option value="Sudão">Sudão</option>
                <option value="Sudão do Sul">Sudão do Sul</option>
                <option value="Marrocos">Marrocos</option>
                <option value="Argélia">Argélia</option>
                <option value="Tunísia">Tunísia</option>
                <option value="Egipto">Egipto</option>
                <option value="Líbia">Líbia</option>
            </optgroup>
            <optgroup label="🌐 Europa e Outros">
                <option value="Portugal">Portugal</option>
                <option value="Brasil">Brasil</option>
                <option value="Reino Unido">Reino Unido</option>
                <option value="França">França</option>
                <option value="Alemanha">Alemanha</option>
                <option value="Espanha">Espanha</option>
                <option value="Itália">Itália</option>
                <option value="China">China</option>
                <option value="Índia">Índia</option>
                <option value="Estados Unidos">Estados Unidos</option>
                <option value="Outro">Outro</option>
            </optgroup>
        </select>
    </div>

    {{-- Cidade --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            {{ $labelCity }} @if($required)<span class="text-red-500">*</span>@endif
        </label>

        {{-- Select (quando há cidades predefinidas) --}}
        <template x-if="cities.length > 0">
            <select
                :name="'{{ $cityName }}'"
                x-model="city"
                {{ $required ? 'required' : '' }}
                class="{{ $selectClass }}">
                <option value="">Seleccionar cidade</option>
                <template x-for="c in cities" :key="c">
                    <option :value="c" :selected="city === c" x-text="c"></option>
                </template>
            </select>
        </template>

        {{-- Text input (quando não há lista de cidades) --}}
        <template x-if="cities.length === 0">
            <input
                type="text"
                :name="'{{ $cityName }}'"
                x-model="city"
                {{ $required ? 'required' : '' }}
                placeholder="Introduza a cidade"
                class="{{ $selectClass }}" />
        </template>
    </div>

</div>

@once
@push('scripts')
<script>
function locationSelect(initialCountry, initialCity) {
    const cityMap = {
        'Moçambique': [
            'Maputo','Matola','Beira','Nampula','Chimoio','Quelimane','Tete',
            'Lichinga','Pemba','Nacala','Xai-Xai','Inhambane','Maxixe',
            'Montepuez','Cuamba','Angoche','Mocuba','Gurúè','Mocímboa da Praia',
            'Ilha de Moçambique','Chókwè','Ressano Garcia','Dondo',
            'Mandlakazi','António Enes','Milange','Moma','Moatize','Vilankulo'
        ],
        'Angola': [
            'Luanda','Benguela','Huambo','Lubango','Cabinda','Malanje',
            'Namibe','Kuito','Saurimo','Menongue','Uíge','Soyo','N\'dalatando'
        ],
        'África do Sul': [
            'Joanesburgo','Cidade do Cabo','Pretória','Durban','Port Elizabeth',
            'Bloemfontein','East London','Nelspruit','Polokwane','Kimberley'
        ],
        'Tanzânia': [
            'Dar es Salaam','Dodoma','Mwanza','Zanzibar','Arusha','Mbeya','Tanga'
        ],
        'Quénia': [
            'Nairóbi','Mombasa','Kisumu','Nakuru','Eldoret','Malindi'
        ],
        'Zimbabwe': [
            'Harare','Bulawayo','Mutare','Gweru','Kwekwe','Kadoma','Masvingo'
        ],
        'Zâmbia': [
            'Lusaka','Kitwe','Ndola','Kabwe','Livingstone','Chingola'
        ],
        'Malawi': [
            'Lilongwe','Blantyre','Mzuzu','Zomba','Kasungu'
        ],
        'Namíbia': [
            'Windhoek','Rundu','Walvis Bay','Oshakati','Swakopmund'
        ],
        'Portugal': [
            'Lisboa','Porto','Braga','Coimbra','Faro','Évora','Setúbal','Funchal'
        ],
        'Brasil': [
            'São Paulo','Rio de Janeiro','Brasília','Salvador','Fortaleza',
            'Belo Horizonte','Manaus','Curitiba','Recife','Porto Alegre','Maputo'
        ],
        'Nigéria': [
            'Lagos','Abuja','Kano','Ibadan','Kaduna','Port Harcourt','Benin City'
        ],
        'Ghana': [
            'Acra','Kumasi','Tamale','Tema','Cape Coast','Sekondi-Takoradi'
        ],
        'Etiópia': [
            'Adis Abeba','Dire Dawa','Mekele','Bahir Dar','Harar','Gondar'
        ],
        'Ruanda': [
            'Kigali','Butare','Gitarama','Musanze','Ruhengeri'
        ],
        'Uganda': [
            'Kampala','Gulu','Lira','Mbarara','Jinja','Mbale'
        ],
        'Congo (RD)': [
            'Kinshasa','Lubumbashi','Mbuji-Mayi','Kisangani','Goma','Bukavu'
        ],
        'Botswana': [
            'Gaborone','Francistown','Molepolole','Selebi-Phikwe','Maun'
        ],
        'Madagáscar': [
            'Antananarivo','Toamasina','Antsirabe','Mahajanga','Fianarantsoa'
        ],
    };

    return {
        country: initialCountry,
        city:    initialCity,
        cities:  cityMap[initialCountry] || [],

        onCountryChange() {
            this.cities = cityMap[this.country] || [];
            this.city   = this.cities.length > 0 ? this.cities[0] : '';
        }
    };
}
</script>
@endpush
@endonce
