<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
	#map-sebaran {
		height: 70vh;
		min-height: 480px;
		width: 100%;
		border-radius: 8px;
		border: 1px solid #ddd;
	}

	.po-pin {
		position: relative;
		width: 46px;
		height: 56px;
	}

	.po-pin .pin-body {
		width: 42px;
		height: 42px;
		border-radius: 50% 50% 50% 0;
		background: linear-gradient(135deg, #e53935, #b71c1c);
		transform: rotate(-45deg);
		border: 2px solid #fff;
		box-shadow: 0 3px 8px rgba(0, 0, 0, .4);
		position: absolute;
		top: 0;
		left: 2px;
	}

	.po-pin .pin-label {
		position: absolute;
		top: 0;
		left: 2px;
		width: 42px;
		height: 42px;
		line-height: 42px;
		text-align: center;
		color: #fff;
		font-weight: 700;
		font-size: 15px;
	}

	.po-pin.mid .pin-body {
		background: linear-gradient(135deg, #fb8c00, #e65100);
	}

	.po-pin.low .pin-body {
		background: linear-gradient(135deg, #43a047, #1b5e20);
	}

	.sebaran-stat {
		display: flex;
		gap: 12px;
		margin-bottom: 12px;
		flex-wrap: wrap;
	}

	.sebaran-stat .box {
		background: #fff;
		border: 1px solid #e3e3e3;
		border-radius: 8px;
		padding: 8px 16px;
	}

	.sebaran-stat .box b {
		font-size: 20px;
		display: block;
	}

	#geo-status {
		font-size: 12px;
		color: #777;
	}

	.leaflet-popup-content .nm {
		font-weight: 700;
		font-size: 14px;
	}
</style>

<div class="row">
	<div class="col-md-12">
		<div class="sebaran-stat">
			<div class="box"><small>Jumlah CMT</small><b><?php echo $total_cmt ?></b></div>
			<div class="box"><small>Total PO di CMT</small><b><?php echo $total_po ?></b></div>
			<div class="box" style="flex:1;min-width:240px;">
				<small>Legenda label</small><br>
				<span class="badge" style="background:#2e7d32;color:#fff">1-2 PO</span>
				<span class="badge" style="background:#ef6c00;color:#fff">3-5 PO</span>
				<span class="badge" style="background:#c62828;color:#fff">&gt; 5 PO</span>
				<div id="geo-status"></div>
			</div>
		</div>
		<div id="map-sebaran"></div>
	</div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="text/javascript">
	(function() {
		var data = <?php echo json_encode($markers, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
		var map = L.map('map-sebaran').setView([-2.5, 118], 5);
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; OpenStreetMap contributors'
		}).addTo(map);

		var bounds = [];
		var cache = {};
		try {
			cache = JSON.parse(localStorage.getItem('sebaran_geo_cache') || '{}');
		} catch (e) {}

		function esc(s) {
			return $('<div>').text(s == null ? '' : s).html();
		}

		function addMarker(d, lat, lon) {
			var cls = d.jml_po > 5 ? '' : (d.jml_po > 2 ? 'mid' : 'low');
			var icon = L.divIcon({
				className: '',
				html: '<div class="po-pin ' + cls + '"><div class="pin-body"></div><div class="pin-label">' + d.jml_po + '</div></div>',
				iconSize: [46, 56],
				iconAnchor: [23, 54],
				popupAnchor: [0, -50]
			});
			L.marker([lat, lon], {
				icon: icon
			}).addTo(map).bindPopup(
				'<div class="nm">' + esc(d.nama) + '</div>' +
				'<div>' + esc(d.alamat) + '</div><hr style="margin:6px 0">' +
				'<div><b>' + d.jml_po + '</b> PO masih di CMT</div>' +
				'<div style="max-height:120px;overflow:auto;margin-top:4px">' + d.po.map(esc).join('<br>') + '</div>'
			);
			bounds.push([lat, lon]);
		}

		function geocode(q) {
			return $.getJSON('https://nominatim.openstreetmap.org/search', {
				format: 'json',
				limit: 1,
				countrycodes: 'id',
				q: q
			});
		}

		var failed = [],
			i = 0;

		function next() {
			if (i >= data.length) {
				if (bounds.length) {
					map.fitBounds(bounds, {
						padding: [40, 40],
						maxZoom: 12
					});
				}
				$('#geo-status').text(bounds.length + ' dari ' + data.length + ' CMT berhasil ditampilkan' +
					(failed.length ? ' | Alamat tidak ditemukan: ' + failed.join(', ') : ''));
				return;
			}
			var d = data[i++];
			$('#geo-status').text('Memuat lokasi ' + i + '/' + data.length + '...');
			if (!d.alamat) {
				failed.push(d.nama + ' (alamat kosong)');
				return next();
			}
			if (cache[d.alamat]) {
				addMarker(d, cache[d.alamat][0], cache[d.alamat][1]);
				if (bounds.length) {
					map.fitBounds(bounds, {
						padding: [40, 40],
						maxZoom: 12
					});
				}
				return next();
			}
			geocode(d.alamat).done(function(res) {
					if (res && res.length) {
						var lat = parseFloat(res[0].lat),
							lon = parseFloat(res[0].lon);
						cache[d.alamat] = [lat, lon];
						localStorage.setItem('sebaran_geo_cache', JSON.stringify(cache));
						addMarker(d, lat, lon);
					} else {
						failed.push(d.nama);
					}
				}).fail(function() {
					failed.push(d.nama);
				})
				.always(function() {
					setTimeout(next, 1100);
				}); // batas Nominatim 1 request/detik
		}
		next();
	})();
</script>